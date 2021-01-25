<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    

    public function post(){
        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
        ];

        if($this->modelId){
            $datVal =  Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|digits:12', 
                Rule::unique('customers')->ignore($this->modelId),
                'address' => 'required|string',
            ])->validate();
            Customer::find($this->modelId)->update($datVal);
        }else{
            $datVal =  Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|digits:12|unique:customers', 
                'address' => 'required|string',
            ])->validate();
            Customer::create($datVal);
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
