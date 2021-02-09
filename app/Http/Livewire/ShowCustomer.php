<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class ShowCustomer extends Component
{
    public $customer_id;
    public function render()
    {
        return view('livewire.show-customer', ['customer' => Customer::findOrFail($this->customer_id)->transaction()->latest()->get()]);
    }
}
