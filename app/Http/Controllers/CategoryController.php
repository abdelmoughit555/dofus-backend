<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

    public function index()
    {
        return CategoryResource::collection(Category::with('image')->get());
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $category->update($request->validated());

        $category->imageUpdate();

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return 200;
    }
}
