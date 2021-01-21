<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CustomerCreate extends Component
{
    public $customers; 
    public function mount($customers){
        $this->customers = $customers;
    }

    public function render()
    {
        return view('livewire.customer-create');
    }
}
