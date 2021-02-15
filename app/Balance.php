<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = ['hutang', 'transaction_id'];

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }
}
