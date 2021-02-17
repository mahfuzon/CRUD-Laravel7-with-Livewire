<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use Livewire\WithPagination;

class ShowCustomer extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $customer_id, $to, $from;
    public $index = 5;

    public function render()
    {
        return view('livewire.show-customer', [
            'customer' => $this->from === null && $this->to === null ? Customer::findOrFail($this->customer_id)->transaction()->orderBy('date', 'ASC')->paginate($this->index) :
                Customer::findOrFail($this->customer_id)->transaction()->latest()->whereBetween('date', [$this->from, $this->to])->paginate($this->index)
        ]);
    }
}
