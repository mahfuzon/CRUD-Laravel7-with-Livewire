<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Customer;

class CustomerIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $action;
    public $selectedItem;

    public function selectItem($itemId, $action){
        $this->selectedItem = $itemId;
        if($action=='delete'){
            $this->dispatchBrowserEvent('openDeleteModal');
        }else{
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModal');
        }
    }
    protected $listeners = [
        'refreshTable'
    ];

    public function render()
    {
        return view('livewire.customer-index', [
            'customer' => Customer::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }

    public function refreshTable(){
        
    }

    public function delete(){
        Customer::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    private function resetForm(){
        $this->name = null;
        $this->phone = null;
        $this->address = null;
    }

    public function store(){
        
        $validatedData= $this->validate([
            'name' => 'required|string',
            'phone' => 'required|integer|unique:customers',
            'address' => 'required|string'
        ]);
        Customer::create($validatedData);
        session()->flash('message', 'Data created successfully!!');
        $this->resetForm();
        $this->emit('customerAdded');
    }
}
