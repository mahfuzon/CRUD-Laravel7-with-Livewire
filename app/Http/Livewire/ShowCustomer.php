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
        $transaction_customer = Customer::find($transaction->customer_id)->transaction()->get();
        $sort = $transaction_customer->sortBy('date');
        $transaction_customer_sort = collect(array_values($transaction_customer->sortBy('date')->toArray()));
        $transaction_where_clause_before = $transaction_customer_sort->where('date', '<', $transaction->date);
        // dd($transaction_where_clause_before);
        $after = $sort->where('date', '>', $transaction->date);
        $before = $sort->where('date', '<', $transaction->date);
        $transaction_where_clause_after = $transaction_customer_sort->where('date', '>', $transaction->date);
        if (!$transaction_where_clause_before->count()) {
            $transaction->delete();
            foreach ($after as $item) {
                $item->hutang -= $transaction->hutang;
                $item->save();
            }
        } else if ($after->count() == 0) {
            $transaction->delete();
        } else {
            $transaction->delete();
            $last_array = array_values($transaction_where_clause_before->toArray());
            $last_hutang = $last_array[count($last_array) - 1]['hutang'];
            $first_array = array_values($transaction_where_clause_after->toArray());
            $first_hutang = $first_array[1];
            $collection_first = collect($first_hutang);
            $hutang_sebelum = $last_array[count($last_array) - 1]['hutang'];
            foreach ($after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
            }
        }

        $this->dispatchBrowserEvent('closeDeleteModalTransactionCustomer');
        $this->dispatchBrowserEvent('deleted');
    }
}
