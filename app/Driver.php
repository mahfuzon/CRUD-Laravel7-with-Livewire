<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'phone'];

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
}
