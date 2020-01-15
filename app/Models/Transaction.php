<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillabled = [
        'amount'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
