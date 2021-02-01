<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use App\Driver;
use App\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionCreate extends Component
{
    public $customer_id, $date, $berat_ikan, $jlh_kantong, $harga_ikan, $driver_id, $bayar, $modelId, $total_berat, $total_harga;

    public function clearForm()
    {
        $this->modelId = null;
        $this->customer_id = null;
        $this->date = null;
        $this->berat_ikan = null;
        $this->jlh_kantong = null;
        $this->harga_ikan = null;
        $this->driver_id = null;
        $this->bayar = null;
    }

    protected $listeners = [
        'getModelId', 'clearForm'
    ];

    public function post()
    {
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        $data = [
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'berat_ikan' => $this->berat_ikan,
            'jlh_kantong' => $this->jlh_kantong,
            'harga_ikan' => $this->harga_ikan,
            'driver_id' => $this->driver_id,
            'bayar' => $this->bayar,
            'total_berat' => $this->total_berat,
            'total_harga' => $this->total_harga,
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
                'customer_id' => 'required|integer',
                'date' => 'required|date',
                'berat_ikan' => 'required|integer',
                'jlh_kantong' => 'required|integer',
                'harga_ikan' => 'required|integer',
                'bayar' => 'required|integer',
                'total_berat' => 'required|integer',
                'total_harga' => 'required|integer',
                'driver_id' => 'required|integer',
            ])->validate();
            Transaction::create($datVal);
        }
        $this->emit('refreshTable');
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeModalTransaction');
        $this->clearForm();
    }

    public function render()
    {
        return view('livewire.transaction-create', [
            'customer' => Customer::all(),
            'driver' => Driver::all()
        ]);
    }
}
