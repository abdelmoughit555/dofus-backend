<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'subtotal',
        'serial',
        'type',
        'currency',
        'method'
    ];

    protected $with = ['user'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->status = 'pending';

            auth()->user()->update([
                'player' => request()->player,
                'server' => request()->player,
                'rib' => request()->rib,
                'card_id' => request()->card_id
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'quantity',
                'price',
                'type'
            ]);
    }

    public function transaction()
    {
        return $this->hasMany(Order::class);
    }
}
