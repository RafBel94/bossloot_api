<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class OrderController extends BaseController
{
    // Method to get the user's orders
    public function index()
    {
        try {
            $orders = Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->with('items')
                ->get();
                
            return $this->sendResponse($orders, 'Orders retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error retrieving orders: ' . $e->getMessage());
            return $this->sendError('Error retrieving orders', ['Failed to retrieve orders: ' . $e->getMessage()], 500);
        }
    }
    
    // Method to get a specific order
    public function show($id)
    {
        try {
            $order = Order::where('user_id', Auth::id())
                ->where('id', $id)
                ->with('items')
                ->firstOrFail();
                
            return $this->sendResponse($order, 'Order retrieved successfully.');
        } catch (\Exception $e) {
            Log::error('Error retrieving order: ' . $e->getMessage());
            return $this->sendError('Order not found', ['Failed to retrieve order: ' . $e->getMessage()], 404);
        }
    }
    
    // Method to create an order from the cart
    public function checkout()
    {
        try {
            DB::beginTransaction();

            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->with('items.product')
                ->firstOrFail();
                
            if ($cart->items->isEmpty()) {
                DB::rollBack();
                return $this->sendError('Cart is empty', ['The cart is empty'], 400);
            }
            
            // Crear la orden a partir del carrito
            $order = Order::createFromCart($cart);
            
            // TODO - Aquí después se integrará con PayPal

            DB::commit();

            return $this->sendResponse($order->load('items'), 'Order created successfully.');
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Cart not found: ' . $e->getMessage());
            return $this->sendError('Cart not found', ['Failed to find cart: ' . $e->getMessage()], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            return $this->sendError('Error creating order', ['Failed to create order: ' . $e->getMessage()], 500);
        }
    }
}