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
    public $index = 5;
    public $keyword;

    protected $queryString = ['keyword'];
    
    public function mount(){
        $this->keyword = request()->query('keyword', $this->keyword);
    }

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModalCustomer');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModalCustomer');
        }
    }

    protected $listeners = ['refreshTable'];

    public function render()
    {
        return view('livewire.customer-index', [
            'customer' => $this->keyword === null ?  Customer::orderBy('created_at', 'DESC')->paginate($this->index) :
                Customer::latest()->where('name', 'like', "%" . $this->keyword . "%")
                ->orWhere('phone', 'like', "%" . $this->keyword . "%")->orWhere('address', 'like', "%" . $this->keyword . "%")
                ->paginate($this->index)
        ]);
    }

    public function clearForm()
    {
        $this->emit('clearForm');
    }

    public function delete()
    {
        Customer::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModalCustomer');
    }

    public function refreshTable()
    {
    }
}
