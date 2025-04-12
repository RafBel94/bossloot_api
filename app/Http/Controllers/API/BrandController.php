<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Brand;

class BrandController extends BaseController
{
    public function index()
    {
        $brands = Brand::all();

        return $this->sendResponse($brands, 'Brands retrieved successfully.');
    }

    public function create()
    {
        // todo: Show the form for creating a new resource
    }

    public function store(Request $request)
    {
        // todo: Store a newly created resource in storage
    }

    public function show($id)
    {
        $brand = Brand::find($id);

        if ($brand == null) {
            return $this->sendError('Brand not found.');
        }

        return $this->sendResponse($brand, 'Brand retrieved successfully.');
    }

    public function edit($id)
    {
        // todo: Show the form for editing the specified resource
    }

    public function update(Request $request, $id)
    {
        // todo: Update the specified resource in storage
    }

    public function destroy($id)
    {
        // todo: Remove the specified resource from storage
    }
}
