<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Reservation;
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
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = '/storage/' . $imagePath;
        }

        $product->save();

        return response()->json(['message' => 'Product created successfully'], 201);
    }
    public function numberOfTotalProducts()
    {
        $products = Product::all()->count();
        return $products;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json("product deleted succesfully");
    }
    public function showProduct($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json([
            'message' => 'product retrieved successfully',
            'data' => $product
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $product = Product::where('id', $id)->firstOrFail();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');

            if ($request->hasFile('image')) {
                // Optional: delete old image if exists
                if ($product->image && \Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
                    \Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
                }

                // Store new image
                $imagePath = $request->file('image')->store('products', 'public');
                $product->image = '/storage/' . $imagePath;
            }

            $product->save();

            return response()->json("Product with id: {$id} was updated successfully");
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update product',
                'error' => $e->getMessage(),
            ], 500);
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
    public function reservationsForThisProduct($id)
    {
        try {
            $reservationsForThisProduct = Reservation::where('product_id', $id)->first();
            return response()->json(
                [
                    'data' => $reservationsForThisProduct,

                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed to load reservations for this product',
                'code' => 400
            ]);
        }
    }
}
