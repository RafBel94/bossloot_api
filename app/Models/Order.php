<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\CurrencyExchangeService;

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
    
    /**
     * Gets the total converted according to the currency using the conversion service
     * 
     * @param string|null $targetCurrency The target currency (if null, uses the order currency)
     * @return float
     */
    public function getConvertedTotal($targetCurrency = null)
    {
        // If no target currency is provided, use the order's currency
        $targetCurrency = $targetCurrency ?: $this->currency;
        
        // If the source and target currencies are the same, no conversion is needed
        if ($this->currency === $targetCurrency) {
            return $this->total_amount;
        }
        
        $exchangeService = app(CurrencyExchangeService::class);
        $convertedAmount = $exchangeService->convert($this->total_amount, 'EUR', $targetCurrency);
        
        return $convertedAmount ?? $this->total_amount;
    }
    
    /**
     * Gets the conversion rate for the order's currency
     * 
     * @param string $baseCurrency
     * @return float|null
     */
    public function getConversionRate($baseCurrency = 'EUR')
    {
        if ($this->currency === $baseCurrency) {
            return 1.0;
        }
        
        $exchangeService = app(CurrencyExchangeService::class);
        return $exchangeService->getRate($baseCurrency, $this->currency);
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
        
        return $order;
    }
}