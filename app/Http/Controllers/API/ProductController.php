<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SimpleProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends BaseController
{

    protected $productRelations = [
        'ramSpec',
        'gpuSpec',
        'cpuSpec',
        'motherboardSpec',
        'storageSpec',
        'psuSpec',
        'caseSpec',
        'coolerSpec',
        'displaySpec',
        'keyboardSpec',
        'mouseSpec',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(SimpleProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //TODO
        $product = $request->all();

        $validator = Validator::make($product, [
            'name' => 'required|max:60',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'category' => 'required|max:60',
            'brand' => 'required|max:60',
            'quantity' => 'required|numeric',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($product);
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return $this->sendError('Product not found.');
        }

        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
