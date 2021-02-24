<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Transaction;

class ShowCustomerDetail extends Component
{
    public $id_transaksi, $customer, $date, $jlh_kantong,
        $berat_ikan, $harga_ikan, $bayar, $total_berat, $total_harga, $driver,
        $keterangan, $hutang;

    protected $listeners = ['openModalDetailShow'];

    public function openModalDetailShow($itemId)
    {
        $this->id_transaksi = $itemId;
        $model = Transaction::find($this->id_transaksi);
        $this->date = $model->date->format('d F Y');
        $this->customer = $model->customer->name;
        $this->harga_ikan = $model->harga_ikan;
        $this->jlh_kantong = $model->jlh_kantong;
        $this->berat_ikan = $model->berat_ikan;
        $this->bayar = $model->bayar;
        $this->total_berat = $model->total_berat;
        $this->total_harga = $model->total_harga;
        $this->driver = $model->driver->name;
        $this->keterangan = $model->keterangan;
        $this->hutang = $model->hutang;
        $this->dispatchBrowserEvent('openDetailModalShow');
    }

    public function render()
    {
        return view('livewire.show-customer-detail', ['transaksi' => Transaction::find($this->id_transaksi)]);
    }
}
