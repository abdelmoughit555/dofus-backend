<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPUser extends Model
{
     protected $fillable = [
          "ip",
          "currency",
          "local",
          "country"
     ];

     public function carts()
     {
          return $this->hasMany(Cart::class);
     }

     public function products()
     {
          return $this->belongsToMany(Product::class, 'carts')->withPivot('quantity', 'type', 'price');
     }
}