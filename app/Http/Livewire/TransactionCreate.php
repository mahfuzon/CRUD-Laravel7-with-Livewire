<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Customer;
use App\Driver;
use App\Transaction;
use DateTimeZone;
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
        $this->date = $model->date->format('Y-m-d\TH:i');
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
        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_before = $transactions->where('date', '<', $this->date)->get();
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        if (!$transactions->get()->count() || !$transactions_before->count()) {
            $this->hutang = $this->total_harga - $this->bayar;
        } else {
            $last_transaction = $transactions_before[$transactions_before->count() - 1];
            $this->hutang = $last_transaction->hutang + $this->total_harga - $this->bayar;
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

        $rules = [
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
        ];

        $validator = Validator::make($data, $rules);

        if ($this->modelId) {
            $transaction = Transaction::find($this->modelId);
            $transaction->update($data);
        } else {
            $transaction = Transaction::create($data);
        }

        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_after = $transactions->where('date', '>', $transaction->date)->get();
        if ($transactions_after->count() > 0) {
            $hutang_sebelum = $transaction->hutang;
            foreach ($transactions_after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
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

    public function update()
    {
        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_before = $transactions->where('date', '<', $this->date)->get();
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        if (!$transactions->get()->count() || !$transactions_before->count()) {
            $this->hutang = $this->total_harga - $this->bayar;
        } else {
            $last_transaction = $transactions_before[$transactions_before->count() - 1];
            $this->hutang = $last_transaction->hutang + $this->total_harga - $this->bayar;
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

        $rules = [
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
        ];
        $validator = Validator::make($data, $rules);

        $transaction = Transaction::find($this->modelId);
        $transaction->update($data);

        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_after = $transactions->where('date', '>', $transaction->date)->get();
        if ($transactions_after->count() > 0) {
            $hutang_sebelum = $transaction->hutang;
            foreach ($transactions_after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
            }
        }
        $this->emit('refreshTable');
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeModalTransaction');
        $this->clearForm();
        $this->dispatchBrowserEvent('success');
    }

    public function store()
    {
        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_before = $transactions->where('date', '<', $this->date)->get();
        $this->total_berat = $this->jlh_kantong * $this->berat_ikan;
        $this->total_harga = $this->total_berat * $this->harga_ikan;
        if (!$transactions->get()->count() || !$transactions_before->count()) {
            $this->hutang = $this->total_harga - $this->bayar;
        } else {
            $last_transaction = $transactions_before[$transactions_before->count() - 1];
            $this->hutang = $last_transaction->hutang + $this->total_harga - $this->bayar;
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

        $rules = [
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
        ];

        $validator = Validator::make($data, $rules);


        $transaction = Transaction::create($data);

        $transactions = Customer::find($this->customer_id)->transaction()->orderBy('date');
        $transactions_after = $transactions->where('date', '>', $transaction->date)->get();
        if ($transactions_after->count() > 0) {
            $hutang_sebelum = $transaction->hutang;
            foreach ($transactions_after as $item) {
                $item->hutang = $hutang_sebelum + $item->total_harga - $item->bayar;
                $item->save();
                $hutang_sebelum = $item->hutang;
            }
        }
        $this->emit('refreshTable');
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeModalTransaction');
        $this->clearForm();
        $this->dispatchBrowserEvent('success');
    }
}
