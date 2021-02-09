<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use Livewire\WithPagination;

class ShowCustomer extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $customer_id, $to;
    public $from;

    public function render()
    {
        return view('livewire.show-customer', ['customer' => $this->from === null && $this->to === null ? Customer::findOrFail($this->customer_id)->transaction()->latest()->paginate(3):
        Customer::findOrFail($this->customer_id)->transaction()->latest()->whereBetween('date', [$this->from, $this->to])->paginate(3)
        ]);
    }
}
