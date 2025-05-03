<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends BaseController
{
    /**
     * Display a list of the user's favorites.
     */
    public function getUserFavorites(String $id)
    {
        $favorites = Favorite::where('user_id', $id)->with('product')->get();
        return $this->sendResponse($favorites, 'Favorites retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FavoriteRequest $request)
    {
        $favorite = Favorite::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);
        return $this->sendResponse([$favorite], 'Favorite created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $userId, String $productId)
    {
        $favorite = Favorite::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($favorite) {
            return $this->sendResponse([$favorite], 'Favorite retrieved successfully.');
        } else {
            return $this->sendError('Favorite not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $userId, String $productId)
    {
        $favorite = Favorite::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($favorite) {
            $favorite->delete();
            return $this->sendResponse([], 'Favorite deleted successfully.');
        } else {
            return $this->sendError('Favorite not found.');
        }
    }
}
