<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductAdminResource;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return ProductAdminResource::collection($products);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductAdminResource($product);
    }

    public function show(Product $products_admin)
    {
        $product = $products_admin->load('categories');
        return new ProductAdminResource($product);
    }

    public function update(Product $products_admin, ProductRequest $request)
    {
        $products_admin->update(array_merge(
            $request->except('is_buyable', 'is_buyable'), [
            'is_buyable' => request()->is_buyable === "true" ? true : false,
            'is_sellable' => request()->is_sellable === "true" ? true : false,
        ]));
        $products_admin->imageUpdate();
        $products_admin->syncCategory();

        return new ProductAdminResource($products_admin);
    }

    public function destroy(Product $products_admin)
    {
        $products_admin->delete();

        return 200;
    }
}
