<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerIndex extends Component
{
    public $customers;

    protected $listeners = [
        'customerStore' => 'handleStore',
    ];
    public function render()
    {
        $this->customers = Customer::all();
        return view('livewire.customer-index');
    }

    public function handleStore($customer){

    }
}
