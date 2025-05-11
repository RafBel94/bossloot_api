<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'cart_id', 
        'status', 
        'payment_method', 
        'payment_id', 
        'total_amount', 
        'currency',
        'notes'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // Method for creating an order from a cart
    public static function createFromCart(Cart $cart)
    {
        $order = new self();
        $order->user_id = $cart->user_id;
        $order->cart_id = $cart->id;
        $order->total_amount = $cart->total_amount;
        $order->currency = $cart->currency;
        $order->status = 'pending_payment';
        $order->save();
        
        // Create order items from cart items
        foreach ($cart->items as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->product_name = $cartItem->product->name;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->unit_price = $cartItem->unit_price;
            $orderItem->total_price = $cartItem->total_price;
            $orderItem->save();
        }
        
        // Mark the cart as processed
        // NOW THIS IS HANDLED IN THE capturePayment() method of PayPalController
        // $cart->status = 'processed';
        // $cart->save();
        
        return $order;
    }
}