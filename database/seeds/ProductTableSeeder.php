<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{

    public function run()
    {
        Product::unsetEventDispatcher();
        $products = factory(Product::class, 20)->create();

        $categories = Category::all();

        $products->each(function($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}