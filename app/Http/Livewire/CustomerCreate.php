<?php

namespace App\Http\Livewire;

use App\Customer;
use Livewire\Component;

class CustomerCreate extends Component
{
    public $name, $phone, $address; 

    public function render()
    {
        return view('livewire.customer-create');
    }

    public function store(){
        $customer = Customer::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address
        ]);
        $this->resetInput();

        $this->emit('customerStore', $customer);
    }

    private function resetInput(){
        $this->name = null;
        $this->phone = null;
        $this->address = null;
    }
}
