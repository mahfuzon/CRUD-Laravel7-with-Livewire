<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'hutang'];

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
}
