<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;

class CustomerCreate extends Component
{
    public $name, $phone, $address, $modelId;

    protected $listeners = [
        'getModelId'
    ];

    public function render()
    {
        return view('livewire.customer-create');
    }

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|digits:12|unique:customers',
        'address' => 'required|string',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function post(){
        $data = $this->validate();

        if($this->modelId){
            Customer::find($this->modelId)->update($data);
        }else{
            Customer::create($data);
        }
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }

    private function clearForm(){
        $this->modelId = null;
        $this->name = null;
        $this->phone = null;
        $this->address = null;
    }


    public function getModelId($modelIdc){
        $this->modelId = $modelIdc;
        $model = Customer::find($this->modelId);
        $this->name = $model->name;
        $this->phone = $model->phone;
        $this->address = $model->address;
    }
}
