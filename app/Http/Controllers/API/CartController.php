<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class CartController extends BaseController
{
    public function index()
    {
        try {
            $cart = $this->getOrCreateCart();
            return $this->sendResponse($cart, 'Cart retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error retrieving cart: ' . $e->getMessage());
            return $this->sendError('Error retrieving cart', ['Failed to retrieve cart: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to add an item to the cart
    public function addItem(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validate the request
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);
            
            $cart = $this->getOrCreateCart();
            $product = Product::findOrFail($request->product_id);
            
            // Verify if the product is already in the cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();
                
            if ($cartItem) {
                // --- Update existing item
                $cartItem->quantity += $request->quantity;
                $cartItem->updateTotalPrice();
            } else {
                // --- Create new item
                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->product_id = $product->id;
                $cartItem->quantity = $request->quantity;
                $cartItem->unit_price = $product->price;
                $cartItem->total_price = $product->price * $request->quantity;
                $cartItem->save();
            }
            
            // Update the cart total
            $cart->updateTotal();

            DB::commit();

            return $this->sendResponse($cart, "Product added to cart");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding item to cart: ' . $e->getMessage());
            return $this->sendError('Error adding item to cart', ['Failed to add item: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to update the quantity of an item in the cart
    public function updateItem(Request $request, $itemId)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
            
            
            $cart = $this->getOrCreateCart();
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('id', $itemId)
                ->firstOrFail();
                
            $cartItem->quantity = $request->quantity;
            $cartItem->updateTotalPrice();
            $cart->updateTotal();
            
            DB::commit();
            
            return $this->sendResponse($cart, "Cart updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating cart item: ' . $e->getMessage());
            return $this->sendError('Error updating cart item', ['Failed to update item: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to remove an item from the cart
    public function removeItem($itemId)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getOrCreateCart();
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('id', $itemId)
                ->firstOrFail();
                
            $cartItem->delete();
            $cart->updateTotal();

            DB::commit();
            
            return $this->sendResponse($cart, "Item removed from cart");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error removing item from cart: ' . $e->getMessage());
            return $this->sendError('Error removing item from cart', ['Failed to remove item: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to clear the cart
    public function clear()
    {
        try {
            DB::beginTransaction();

            $cart = $this->getOrCreateCart();
            $cart->items()->delete();
            $cart->updateTotal();

            DB::commit();
            
            return $this->sendResponse($cart, "Cart emptied successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error clearing cart: ' . $e->getMessage());
            return $this->sendError('Error clearing the cart', ['Failed to clear cart: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to get or create a cart for the authenticated user
    private function getOrCreateCart()
    {
        try {
            DB::beginTransaction();

            $userId = Auth::id();
            
            $cart = Cart::where('user_id', $userId)
                ->where('status', 'active')
                ->first();
                
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = $userId;
                $cart->status = 'active';
                $cart->save();
            }

            DB::commit();
            
            return $cart;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error getting or creating cart: ' . $e->getMessage());
            throw $e; // Rethrow the exception to be handled by the calling method
        }
    }
}