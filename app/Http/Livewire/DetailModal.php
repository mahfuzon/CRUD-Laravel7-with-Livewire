<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Transaction;

class DetailModal extends Component
{
    public $id_transaksi;
    public $transaksi;

    protected $listeners = ['openModalDetail'];

    public function openModalDetail($itemId)
    {
        $this->id_transaksi = $itemId;
        $this->transaksi = Transaction::findOrFail($this->id_transaksi);
        $this->dispatchBrowserEvent('openDetailModal');
    }

    public function render()
    {
        return view('livewire.detail-modal');
    }
}
