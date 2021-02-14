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
            'transaction' =>  $this->from === null && $this->to === null ? Transaction::orderBy('created_at', 'DESC')->paginate($this->index) :
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
        $id_customer = Transaction::find($this->selectedItem)->customer_id;
        $hutang_transaksi = Transaction::find($this->selectedItem)->total_harga;
        $customer = Customer::find($id_customer);
        $customer->hutang -= $hutang_transaksi;
        $customer->save();
        Transaction::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModalTransaction');
        $this->session('delete');
    }

    public function refreshTable()
    {
    }

    public function session($string)
    {
        if ($string === 'update') {
            session()->flash('message', 'transaction successfully updated.');
        } else if ($string === 'create') {
            session()->flash('message', 'transaction successfully created.');
        } else {
            session()->flash('message', 'transaction successfully deleted.');
        }
    }
}
