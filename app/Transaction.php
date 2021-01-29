<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id', 'driver_id', 'date', 'jlh_kantong',
        'jlh_ikan', 'price', 'total_ikan', 'total_price', 'bayar'
    ];

    public function customers()
    {
        return $this->belongsTo('App\Customer');
    }

    public function drivers()
    {
        return $this->belongsTo('App\Driver');
    }
}
