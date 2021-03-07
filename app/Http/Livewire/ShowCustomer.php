<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use App\Transaction;
use Livewire\WithPagination;

class ShowCustomer extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $customer_id, $to, $from;
    public $index = 20;
    public $selectedItem;

    public function render()
    {
        return view('livewire.show-customer', [
            'customer' => $this->from === null && $this->to === null ? Customer::findOrFail($this->customer_id)->transaction()->orderBy('date', 'ASC')->paginate($this->index) :
                Customer::findOrFail($this->customer_id)->transaction()->latest()->whereBetween('date', [$this->from, $this->to])->paginate($this->index)
        ]);
    }

    public function resetInput()
    {
        $this->from = null;
        $this->to = null;
    }

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModalTransactionCustomer');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openEditModalTransactionCustomer');
        }
    }

    public function refreshTable()
    {
    }

    protected $listeners = [
        'refreshTable'
    ];

    public function delete()
    {
        $transaction = Transaction::find($this->selectedItem);
        $transactions = Customer::find($transaction->customer_id)->transaction()->orderBy('date');
        $transactions_before = $transactions->where('date', '<', $transaction->date)->get();

        $transaction->delete();

        $transactions = Customer::find($transaction->customer_id)->transaction()->orderBy('date');
        $transactions_after = $transactions->where('date', '>', $transaction->date)->get();

        if (!$transactions_before->count()) {
            foreach ($transactions_after as $item) {
                $item->hutang -= $transaction->hutang;
                $item->save();
            }
        } else {
            $last_transaction = $transactions_before[$transactions_before->count() - 1];
            $hutang_sebelum = $last_transaction->hutang;
            foreach ($transactions_after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
            }
        }
        $this->dispatchBrowserEvent('closeDeleteModalTransactionCustomer');
        $this->dispatchBrowserEvent('deleted');
    }
}
