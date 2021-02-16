<?php

namespace App\Http\Livewire;

use App\Balance;
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
        $transaction_customer = Customer::find($this->customer_id)->transaction;
        $data2 = [
            'customer_id' => $this->customer_id,
        ];
        Validator::make($data2, [
            'customer_id' => 'required|integer',
        ])->validate();
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
            'bayar' => $this->bayar,
            'keterangan' => $this->keterangan,
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
                'keterangan' => 'required|string',
                'total_berat' => 'required|integer',
                'total_harga' => 'required|integer',
                'driver_id' => 'required|integer',
            ])->validate();
            $model_transaction = Transaction::find($this->modelId);
            $model_transaction->update($datVal);
            // dd($model_transaction->id);30
            $transaction_by_id = $transaction_customer->where('id', '<', $model_transaction->id);
            // dd($transaction_by_id); array 4 buah
            if ($transaction_by_id->count() > 0) {
                $transaction_before = $transaction_by_id[count($transaction_by_id) - 1];
                // dd($transaction_before);  1 objek sebelum model update 
                $balance_before = Balance::where('transaction_id', $transaction_before->id)->first();
                $model_balance = Balance::where('transaction_id', $model_transaction->id)->first();
                $model_balance->hutang = $balance_before->hutang + $model_transaction->total_harga - $model_transaction->bayar;
                $model_balance->save();
            } else {
                $model_balance = Balance::where('transaction_id', $model_transaction->id)->first();
                $model_balance->hutang = $model_transaction->total_harga - $model_transaction->bayar;
                $model_balance->save();
            }
            // 1, ambil data transaksi > $model_transaction
            $transaction_after = $transaction_customer->where('id', '>', $model_transaction->id);
            // dd($transaction_after);
            // 2. ambil data balance > $model_balance
            $balance_after = Balance::where('id', '>', $model_balance->id)->get();
            dd($transaction_after);
            // 3. masukkan ke perulangan sebanyak jumlah row yang ditemukan
            $balance_sebelum = $model_balance;

            foreach ($balance_after as $item) {
                $transaction = $transaction_after->where('id', $item->transaction_id)->first();
                $harga_total = $transaction->total_harga;
                $bayar_total = $transaction->bayar;

                $balance_baru = $item;
                $balance_baru->hutang = $balance_sebelum->hutang + $harga_total - $transaction->bayar;
                $balance_baru->save();

                $balance_sebelum = $balance_baru;
            }
        } else {
            $datVal =  Validator::make($data, [
                'customer_id' => 'required|integer',
                'date' => 'required|date',
                'berat_ikan' => 'required|integer',
                'jlh_kantong' => 'required|integer',
                'harga_ikan' => 'required|integer',
                'bayar' => 'required|integer',
                'keterangan' => 'required|string',
                'total_berat' => 'required|integer',
                'total_harga' => 'required|integer',
                'driver_id' => 'required|integer',
            ])->validate();
            // ========================================================================================================
            if ($transaction_customer->count() == 0) {
                $model_transaction = Transaction::create($datVal);

                $model_balance = Balance::create([
                    'transaction_id' => $model_transaction->id,
                    'hutang' => $model_transaction->total_harga - $model_transaction->bayar
                ]);
            } else {
                $model_transaction = Transaction::create($datVal);
                $transaction_by_id = $transaction_customer->where('id', '<', $model_transaction->id);
                $transaction_before = $transaction_by_id[count($transaction_customer) - 1];
                $balance_before = Balance::where('transaction_id', $transaction_before->id)->first();
                $model_balance = Balance::create([
                    'transaction_id' => $model_transaction->id,
                    'hutang' => $balance_before->hutang + $model_transaction->total_harga - $model_transaction->bayar
                ]);
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
