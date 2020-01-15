<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{

    public function run()
    {
        Category::unsetEventDispatcher();

        $categories = factory(Category::class, 3)->create();
    }
}