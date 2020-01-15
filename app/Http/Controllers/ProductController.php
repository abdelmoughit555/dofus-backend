<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Scoping\Scopes\CategoryScope;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::withScopes($this->scopes())
            ->with('image')
            ->orderBy('created_at', 'desc')
            ->get();

        return ProductResource::collection($product);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        $product = $product->load('categories');

        return new ProductResource($product);
    }

    public function update(Product $product, ProductRequest $request)
    {
        $product->update($request->validated());

        $product->syncCategory();

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return 200;
    }

    protected function scopes()
    {
        return [
            'category' => new CategoryScope
        ];
    }
}
