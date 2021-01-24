<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Customer;

class CustomerIndex extends Component
{
    public $prompt;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'refreshTable'
    ];

    public function render()
    {
        return view('livewire.customer-index', [
            'customer' => Customer::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }

    public function refreshTable(){
        $this->prompt = 'Ini adalah Modal';
    }
}
