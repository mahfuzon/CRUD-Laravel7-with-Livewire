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
        $driver_id, $bayar, $modelId, $total_berat, $total_harga, $hutang, $keterangan;

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
        $this->keterangan = $model->keterangan;
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
        $this->keterangan = null;
        $this->bayar = null;
        $this->resetErrorBag();
    }

    protected $listeners = [
        'getModelId', 'clearForm'
    ];

    public function post()
    {
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        $this->hutang = $this->total_harga - $this->bayar;
        $data = [
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'berat_ikan' => $this->berat_ikan,
            'jlh_kantong' => $this->jlh_kantong,
            'harga_ikan' => $this->harga_ikan,
            'driver_id' => $this->driver_id,
            'hutang' => $this->hutang,
            'bayar' => $this->bayar,
            'keterangan' => $this->keterangan,
            'total_berat' => $this->total_berat,
            'total_harga' => $this->total_harga,
        ];

        $datVal =  Validator::make($data, [
            'customer_id' => 'required|integer',
            'date' => 'required|date',
            'berat_ikan' => 'required|integer',
            'jlh_kantong' => 'required|integer',
            'harga_ikan' => 'required|integer',
            'bayar' => 'required|integer',
            'hutang' => 'required|integer',
            'keterangan' => 'required|string',
            'total_berat' => 'required|integer',
            'total_harga' => 'required|integer',
            'driver_id' => 'required|integer',
        ])->validate();

        if ($this->modelId) {
            $transaction_customer = Customer::find($this->customer_id)->transaction;
            $transaction_before = $transaction_customer->where('id', '<', $this->modelId);

            if ($transaction_before->count() == 0) {
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $this->total_harga - $this->bayar;
            } else {
                $transaction_before_last = $transaction_before[count($transaction_before) - 1];
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $transaction_before_last->hutang + $this->total_harga - $this->bayar;
            }


            $data = [
                'customer_id' => $this->customer_id,
                'date' => $this->date,
                'berat_ikan' => $this->berat_ikan,
                'jlh_kantong' => $this->jlh_kantong,
                'harga_ikan' => $this->harga_ikan,
                'driver_id' => $this->driver_id,
                'hutang' => $this->hutang,
                'bayar' => $this->bayar,
                'keterangan' => $this->keterangan,
                'total_berat' => $this->total_berat,
                'total_harga' => $this->total_harga,
            ];

            $datVal =  Validator::make($data, [
                'customer_id' => 'required|integer',
                'date' => 'required|date',
                'berat_ikan' => 'required|integer',
                'jlh_kantong' => 'required|integer',
                'harga_ikan' => 'required|integer',
                'bayar' => 'required|integer',
                'hutang' => 'required|integer',
                'keterangan' => 'required|string',
                'total_berat' => 'required|integer',
                'total_harga' => 'required|integer',
                'driver_id' => 'required|integer',
            ])->validate();
            $model_transaction = Transaction::find($this->modelId);
            $model_transaction->update($datVal);
            $transaction_after = $transaction_customer->where('id', '>', $this->modelId);
            $hutang_sebelum = $model_transaction->hutang;
            foreach ($transaction_after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
            }
            // $transaction_after->hutang = $model_transaction->hutang + $transaction_after->total_harga - $transaction_after->bayar;
            // $transaction_after->save();
            // $hutang_sebelum = $model_transaction->hutang;

            // dd($hutang_sebelum);
            // foreach ($transaction_after as $item) {
            //     $model_transaction_baru = $item;
            //     // dd($model_transaction_baru);
            //     $model_transaction->hutang = $hutang_sebelum + $model_transaction_baru->total_harga - $model_transaction_baru->bayar;
            //     $model_transaction_baru->save();
            //     $hutang_sebelum = $model_transaction_baru->hutang;
            // }
        } else {
            $transaction_customer = Customer::find($this->customer_id)->transaction;
            if ($transaction_customer->count() == 0) {
                $model_transaction = Transaction::create($datVal);
            } else {
                $transaction_last = $transaction_customer[count($transaction_customer) - 1];
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $transaction_last->hutang + $this->total_harga - $this->bayar;
                $data = [
                    'customer_id' => $this->customer_id,
                    'date' => $this->date,
                    'berat_ikan' => $this->berat_ikan,
                    'jlh_kantong' => $this->jlh_kantong,
                    'harga_ikan' => $this->harga_ikan,
                    'driver_id' => $this->driver_id,
                    'hutang' => $this->hutang,
                    'bayar' => $this->bayar,
                    'keterangan' => $this->keterangan,
                    'total_berat' => $this->total_berat,
                    'total_harga' => $this->total_harga,
                ];

                $datVal =  Validator::make($data, [
                    'customer_id' => 'required|integer',
                    'date' => 'required|date',
                    'berat_ikan' => 'required|integer',
                    'jlh_kantong' => 'required|integer',
                    'harga_ikan' => 'required|integer',
                    'bayar' => 'required|integer',
                    'hutang' => 'required|integer',
                    'keterangan' => 'required|string',
                    'total_berat' => 'required|integer',
                    'total_harga' => 'required|integer',
                    'driver_id' => 'required|integer',
                ])->validate();

                $model_transaction = Transaction::create($datVal);
            }
        }
        $this->emit('refreshTable');
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeModalTransaction');
        $this->clearForm();
        $this->dispatchBrowserEvent('success');
    }

    public function render()
    {
        return view('livewire.transaction-create', [
            'customer' => Customer::all(),
            'driver' => Driver::all()
        ]);
    }
}
