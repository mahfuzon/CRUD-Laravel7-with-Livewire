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
    public $selectedItem, $message;
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

    protected $listeners = ['refreshTable', 'session'];

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
        $this->session('delete');
    }

    public function refreshTable()
    {
    }

    public function session($string)
    {
        if ($string === 'update') {
            session()->flash('message', 'driver successfully updated.');
        } else if ($string === 'create') {
            session()->flash('message', 'driver successfully created.');
        } else {
            session()->flash('message', 'driver successfully deleted.');
        }
    }
}
