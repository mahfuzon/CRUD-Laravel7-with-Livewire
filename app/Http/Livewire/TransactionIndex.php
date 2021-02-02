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

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModaltransaction');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModalTransaction');
        }
    }

    protected $listeners = ['refreshTable', 'session'];

    public function render()
    {
        return view('livewire.transaction-index', [
            'transaction' => Transaction::orderBy('created_at', 'DESC')->paginate($this->index)
        ]);
        $this->session($this->message);
    }

    public function clearForm()
    {
        $this->emit('clearForm');
    }

    public function delete()
    {
        Transaction::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModalTransaction');
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
