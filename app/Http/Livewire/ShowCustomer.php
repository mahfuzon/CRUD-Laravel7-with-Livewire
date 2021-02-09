<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowCustomer extends Component
{
    public $customer_id;
    public function render()
    {
        return view('livewire.show-customer');
    }
}
