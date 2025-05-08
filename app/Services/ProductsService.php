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
    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::where('id', $id)->first();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->save();
            return response()->json("product with id: ${id} was updated successfully");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function listOfProducts()
    {
        try {
            $products = Product::all();

            return response()->json([
                'data' => $products,
                'message' => 'Products list retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve product list',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
