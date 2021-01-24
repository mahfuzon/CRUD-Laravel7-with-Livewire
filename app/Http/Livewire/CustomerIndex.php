<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerIndex extends Component
{
    public $customers, $name, $phone, $address;
    public function render()
    {
        $this->customers = Customer::orderBy('created_at', 'DESC')->get();
        return view('livewire.customer-index');
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
