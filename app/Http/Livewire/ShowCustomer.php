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
    public $index = 20;
    public $selectedItem;

    public function render()
    {
        return view('livewire.show-customer', [
            'customer' => $this->from === null && $this->to === null ? Customer::findOrFail($this->customer_id)->transaction()->orderBy('date', 'ASC')->paginate($this->index) :
                Customer::findOrFail($this->customer_id)->transaction()->latest()->whereBetween('date', [$this->from, $this->to])->paginate($this->index)
        ]);
    }

    public function resetInput()
    {
        $this->from = null;
        $this->to = null;
    }

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModalTransaction');
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openEditModalTransactionCustomer');
        }
    }

    public function refreshTable()
    {
    }

    protected $listeners = [
        'refreshTable'
    ];
}
