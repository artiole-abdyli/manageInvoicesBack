<?php

namespace App\Http\Controllers;

use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductsService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        return $this->productService->listOfProducts();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->productService->createProduct($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->productService->showProduct($id);
    }

    public function numberOfTotalProducts()
    {
        return $this->productService->numberOfTotalProducts();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->productService->updateProduct($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->productService->deleteProduct($id);
    }
    public function productsOptions()
    {
        return $this->productService->productsOptions();
    }
    public function reservationsForThisProduct($id)
    {
        return $this->productService->reservationsForThisProduct($id);
    }
    public function downloadProductsPdf(){
        return $this->productService->downloadProductsPdf();
    }
}
