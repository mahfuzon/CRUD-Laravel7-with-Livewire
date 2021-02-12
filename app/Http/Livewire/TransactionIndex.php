<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\transaction;

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
        if ($action == 'edit') {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModalTransaction');
        }
    }

    protected $listeners = ['refreshTable', 'session', 'delete'];

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

    public function delete($id)
    {
        $this->selectedItem = $id;
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
