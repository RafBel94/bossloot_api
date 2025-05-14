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

        // Usar first() en lugar de firstOrFail()
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with('items.product')
            ->first();
        
        // Verificar manualmente si existe el carrito
        if (!$cart) {
            DB::rollBack();
            return $this->sendError('Cart not found', ['No active cart found for this user'], 404);
        }
        
        if ($cart->items->isEmpty()) {
            DB::rollBack();
            return $this->sendError('Cart is empty', ['The cart is empty'], 400);
        }
        
        // Crear la orden una sola vez
        $order = Order::createFromCart($cart);
        $order->status = 'pending_payment';
        $order->save();

        DB::commit();

        // Usar URL absoluta en lugar de route() para evitar errores
        $paypalUrl = url("/api/paypal/create-order/{$order->id}");

        return $this->sendResponse([
            'order' => $order->load('items'),
            'next_step' => [
                'action' => 'initiate_payment',
                'paypal_url' => $paypalUrl
            ]
        ], 'Order created successfully. Ready for payment.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error creating order: ' . $e->getMessage());
        return $this->sendError('Error creating order', ['Failed to create order: ' . $e->getMessage()], 500);
    }
}
}