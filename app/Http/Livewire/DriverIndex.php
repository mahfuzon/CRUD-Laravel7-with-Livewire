<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Driver;

class DriverIndex extends Component
{
    public function render()
    {
        $driver = Driver::latest()->get();
        return view('livewire.driver-index', ['driver' => $driver]);
    }
}
