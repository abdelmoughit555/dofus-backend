<?php

namespace App\Models;

use App\Models\Traits\IP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Scoper;
use Illuminate\Support\Facades\Storage;
use App\Models\Traits\Imageable;

class Product extends Model
{
    use Imageable, IP;

    protected $with = ["categories"];
    protected $fillable = [
        "name",
        "slug",
        "description",
        "price_sell",
        "price_buy",
        "stock",
        "is_sellable",
        "is_buyable"
    ];

    protected $casts = [
        'is_sellable' => 'boolean',
        'is_buyable' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($product) {
            $product->slug = str_slug(request()->name, '-');
            $product->is_buyable =  request()->is_buyable === "true" ? true : false;
            $product->is_sellable = request()->is_sellable === "true" ? true : false;
        });

        static::created(function($product) {
            $product->storeImage();
            $product->categories()->attach(request()->category_id);
        });

        static::updating(function($product) {
            $product->slug = str_slug(request()->name, '-');
            $product->is_buyable = request()->is_buyable === "true" ? true : false;
            $product->is_sellable = request()->is_sellable === "true" ? true : false;
        });

    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function syncCategory()
    {
        return $this->categories()->sync(request()->category_id);
    }

    public function scopeWithScopes(Builder $builder, $scopes = [])
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }

    public function isBuyable()
    {
        return $this->stock > 0;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wish_lists');
    }
}
