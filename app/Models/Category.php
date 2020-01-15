<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Imageable;

class Category extends Model
{
    use Imageable;

    protected $fillable = ["name","slug", "description"];

    protected static function boot()
    {
        parent::boot();

        static::created(function($category) {
            $category->storeImage();
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
