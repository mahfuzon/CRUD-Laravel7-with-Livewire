<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'phone'];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
