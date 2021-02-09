<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use Livewire\WithPagination;

class ShowCustomer extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $customer_id;
    public function render()
    {
        return view('livewire.show-customer', ['customer' => Customer::findOrFail($this->customer_id)->transaction()->latest()->paginate(3)]);
    }
}
