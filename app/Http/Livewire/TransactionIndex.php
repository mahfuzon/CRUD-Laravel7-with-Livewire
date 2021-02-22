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
    public $action;
    public $selectedItem;
    public $index = 5;
    public $keyword;
    public $message;
    public $from;
    public $to;
    public $customer_id;

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

        $this->dispatchBrowserEvent('closeDeleteModalTransaction');
        $this->dispatchBrowserEvent('deleted');
    }

    public function refreshTable()
    {
    }
}
