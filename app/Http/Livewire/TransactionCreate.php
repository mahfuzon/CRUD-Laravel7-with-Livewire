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
            $transaction_customer = Customer::find($this->customer_id)->transaction()->get();
            $transaction_sortBy_date = $transaction_customer->sortBy('date');
            $array = $transaction_sortBy_date->toArray();
            $transaction_before = $transaction_customer->where('date', '<', $this->modelId);
            $transaction_after = $transaction_customer->where('date', '>', $this->modelId);
            $array_reset = array_values($array);
            $collection = collect($array_reset);
            $transaction_customer_where_clause_before = $collection->where('date', '<', $this->date);
            $transaction_customer_where_clause_after = $collection->where('date', '>', $this->date);

            if (!$transaction_customer->count()) {
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $this->total_harga - $this->bayar;
            } else if (!$transaction_customer_where_clause_before->count()) {
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $this->total_harga - $this->bayar;
            } else {
                $last = $transaction_customer_where_clause_before[$transaction_customer_where_clause_before->count() - 1];
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $last['hutang'] + $this->total_harga - $this->bayar;
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

            $model_transaction_after = $transaction_sortBy_date->where('date', '>', $model_transaction->date);
            if ($model_transaction_after->count() > 0) {
                $hutang_sebelum = $model_transaction->hutang;
                foreach ($model_transaction_after as $item) {
                    $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                    $item->save();
                    $hutang_sebelum = $item->hutang;
                }
            }
        } else {
            $transaction_customer = Customer::find($this->customer_id)->transaction()->get();
            $transaction_sortBy_date = $transaction_customer->sortBy('date');
            $array = $transaction_sortBy_date->toArray();
            $array_reset = array_values($array);
            $collection = collect($array_reset);
            $transaction_customer_where_clause_before = $collection->where('date', '<', $this->date);
            $transaction_customer_where_clause_after = $collection->where('date', '>', $this->date);
            if ($transaction_customer->count() == 0) {
                $model_transaction = Transaction::create($datVal);
            } else if (!$transaction_customer_where_clause_before->count()) {
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

                $model_transaction = Transaction::create($datVal);

                $transaction_customer_where_clause_after = $transaction_sortBy_date->where('date', '>', $model_transaction->date);
                $hutang_sebelum = $model_transaction->hutang;
                foreach ($transaction_customer_where_clause_after as $item) {
                    $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                    $item->save();
                    $hutang_sebelum = $item->hutang;
                }
            } else if (!$transaction_customer_where_clause_after->count()) {
                $last = $transaction_customer_where_clause_before[$transaction_customer_where_clause_before->count() - 1];
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $last['hutang'] + $this->total_harga - $this->bayar;
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
            } else {
                $last = $transaction_customer_where_clause_before[$transaction_customer_where_clause_before->count() - 1];
                $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
                $this->total_harga = $this->total_berat * $this->harga_ikan;
                $this->hutang = $last['hutang'] + $this->total_harga - $this->bayar;
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

                $transaction_customer_where_clause_after = $transaction_sortBy_date->where('date', '>', $model_transaction->date);
                $hutang_sebelum = $model_transaction->hutang;
                foreach ($transaction_customer_where_clause_after as $item) {
                    $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                    $item->save();
                    $hutang_sebelum = $item->hutang;
                }
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
