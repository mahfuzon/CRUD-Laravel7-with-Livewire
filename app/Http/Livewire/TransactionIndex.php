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

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModaltransaction');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModaltransaction');
        }
    }

    protected $listeners = ['refreshTable'];

    public function render()
    {
        return view('livewire.transaction-index', [
            'transaction' => Transaction::orderBy('created_at', 'DESC')->paginate($this->index)
        ]);
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
}
