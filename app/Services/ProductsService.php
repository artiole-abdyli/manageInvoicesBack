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
        $product->number_of_reservation = $request->input('number_of_reservation');
        $product->save();
        return response()->json("product created successfully");
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json("product deleted succesfully");
    }
    public function showProduct($id)
    {
        $product = Product::where('id', $id);
        return response()->json([
            'message' => 'product retrieved successfully',
            'data' => $product
        ]);
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
    public function productsOptions()
    {
        try {
            $products = Product::select('id', 'name')->get()->map(function ($product) {
                return [
                    'label' => $product->name,
                    'value' => $product->id,
                ];
            });

            return response()->json([
                'message' => 'success',
                'code' => 200,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed to load product options',
                'code' => 400
            ]);
        }
    }
}
