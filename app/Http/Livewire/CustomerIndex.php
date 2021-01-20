<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerIndex extends Component
{
    public $customer;
    public function render()
    {
        $this->customer = Customer::all();
        return view('livewire.customer-index');
    }
}
