<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Transaction;
use App\Customer;

class transactionIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $action, $selectedItem, $keyword, $message, $from, $to, $customer_id;
    public $index = 20;

    protected $queryString = ['from', 'to'];

    public function mount()
    {
        $this->from = request()->query('from', $this->from);
        $this->to = request()->query('to', $this->to);
    }

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModalTransaction');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModalTransaction');
        }
    }

    protected $listeners = ['refreshTable', 'session'];

    public function render()
    {

        return view('livewire.transaction-index', [
            'transaction' =>  $this->from === null && $this->to === null ? Transaction::orderBy('date', 'DESC')->paginate($this->index) :
                Transaction::latest()->whereBetween('date', [$this->from, $this->to])
                ->paginate($this->index)
        ]);
        $this->session($this->message);
    }

    public function clearForm()
    {
        $this->emit('clearForm');
    }

    public function refreshTable()
    {
    }

    public function resetInput()
    {
        $this->from = null;
        $this->to = null;
    }

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
        $this->dispatchBrowserEvent('closeDeleteModalTransaction');
        $this->dispatchBrowserEvent('deleted');
    }
}