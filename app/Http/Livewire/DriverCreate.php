<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Driver;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DriverCreate extends Component
{
    public $name, $phone, $modelId;

    protected $listeners = [
        'getModelId', 'clearForm'
    ];

    public function render()
    {
        return view('livewire.driver-create');
    }


    public function post()
    {
        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
        ];

        if ($this->modelId) {
            $datVal =  Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|digits:12',
                Rule::unique('Drivers')->ignore($this->modelId),
            ])->validate();
            Driver::find($this->modelId)->update($datVal);
        } else {
            $datVal =  Validator::make($data, [
                'name' => 'required|string',
                'phone' => 'required|digits:12|unique:Drivers|numeric',
            ])->validate();
            Driver::create($datVal);
        }
        $this->emit('refreshTable');
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeModalDriver');
        $this->clearForm();
    }

    public function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->phone = null;
        $this->resetErrorBag();
    }


    public function getModelId($modelIdc)
    {
        $this->modelId = $modelIdc;
        $model = Driver::find($this->modelId);
        $this->name = $model->name;
        $this->phone = $model->phone;
    }
}
