<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id', 'date', 'jlh_kantong',
        'berat_ikan', 'harga_ikan', 'bayar', 'total_berat', 'total_harga', 'driver_id',
        'keterangan',
    ];

    protected $dates = ['date'];
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function balance()
    {
        return $this->hasOne('App\Balance');
    }
}
