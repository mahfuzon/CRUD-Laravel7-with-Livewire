<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use App\Driver;
use App\Transaction;
use Illuminate\Support\Facades\Validator;

class TransactionCreate extends Component
{
    public $customer_id, $date, $berat_ikan, $jlh_kantong, $harga_ikan,
        $driver_id, $bayar, $modelId, $total_berat, $total_harga, $hutang;

    public function getModelId($modelIdc)
    {
        $this->modelId = $modelIdc;
        $model = Transaction::find($this->modelId);
        $this->customer_id = $model->customer_id;
        $this->date = $model->date->format('Y-m-d');
        $this->berat_ikan = $model->berat_ikan;
        $this->jlh_kantong = $model->jlh_kantong;
        $this->harga_ikan = $model->harga_ikan;
        $this->driver_id = $model->driver_id;
        $this->bayar = $model->bayar;
        $this->total_berat = $model->total_berat;
        $this->total_harga = $model->total_harga;
    }

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
        $this->resetErrorBag();
    }

    protected $listeners = [
        'getModelId', 'clearForm'
    ];

    public function post()
    {
        $data2 = [
            'customer_id' => $this->customer_id,
        ];
        Validator::make($data2, [
            'customer_id' => 'required|integer',
        ])->validate();
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        $this->hutang = $this->total_harga - $this->bayar;
        $customer = Customer::find($this->customer_id);
        $customer->hutang += $this->hutang;
        $customer->save();
        $data = [
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'berat_ikan' => $this->berat_ikan,
            'jlh_kantong' => $this->jlh_kantong,
            'harga_ikan' => $this->harga_ikan,
            'driver_id' => $this->driver_id,
            'bayar' => $this->bayar,
            'hutang' => $customer->hutang,
            'total_berat' => $this->total_berat,
            'total_harga' => $this->total_harga,
        ];

        if ($this->modelId) {
            $datVal =  Validator::make($data, [
                'customer_id' => 'required|integer',
                'date' => 'required|date',
                'berat_ikan' => 'required|integer',
                'jlh_kantong' => 'required|integer',
                'harga_ikan' => 'required|integer',
                'bayar' => 'required|integer',
                'total_berat' => 'required|integer',
                'total_harga' => 'required|integer',
                'hutang' => 'integer',
                'driver_id' => 'required|integer',
            ])->validate();
            Transaction::find($this->modelId)->update($datVal);
            $this->emit('session', 'update');
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
                'hutang' => 'integer',
                'driver_id' => 'required|integer',
            ])->validate();
            Transaction::create($datVal);

            $this->emit('session', 'create');
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
