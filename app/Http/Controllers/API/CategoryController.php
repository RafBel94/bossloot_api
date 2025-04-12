<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Category;
class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::all();

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
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
        // todo: Display the specified resource
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
