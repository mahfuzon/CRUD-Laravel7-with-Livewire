<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Driver;

class DriverIndex extends Component
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
            $this->dispatchBrowserEvent('openDeleteModalDriver');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModalDriver');
        }
    }

    protected $listeners = ['refreshTable'];

    public function render()
    {
        return view('livewire.driver-index', [
            'driver' => $this->keyword === null ?  Driver::orderBy('created_at', 'DESC')->paginate($this->index) :
                Driver::latest()->where('name', 'like', "%" . $this->keyword . "%")
                ->orWhere('phone', 'like', "%" . $this->keyword . "%")
                ->paginate($this->index)
        ]);
    }

    public function clearForm()
    {
        $this->emit('clearForm');
    }

    public function delete()
    {
        Driver::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModalDriver');
        $this->dispatchBrowserEvent('deleted');
    }

    public function refreshTable()
    {
    }
}
