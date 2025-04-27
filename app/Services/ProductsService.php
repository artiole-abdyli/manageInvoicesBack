<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function createProduct(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();
        return response()->json("product created successfully");
    }
    public function listOfProducts()
    {
        $products = Product::all();
        return $products;
    }
}
