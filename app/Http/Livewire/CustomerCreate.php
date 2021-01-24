<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerCreate extends Component
{
    public $name, $phone, $address;

    public function render()
    {
        return view('livewire.customer-create');
    }

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|digits:12|unique:customers',
        'address' => 'required|string',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function post(){
        $data = $this->validate();
        Customer::create($data);
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }

    private function clearForm(){
        $this->name = null;
        $this->phone = null;
        $this->address = null;
    }
}
