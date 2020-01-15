<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'i_p_user_id',
        'product_id',
        'quantity',
        'type',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ip()
    {
        return $this->belongsTo(IPUser::class);
    }
}
