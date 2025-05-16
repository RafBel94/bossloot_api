<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\CurrencyExchangeService;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'product_id', 
        'product_name',
        'quantity', 
        'unit_price', 
        'total_price'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Gets the unit price converted to the target currency
     * 
     * @param string $targetCurrency The target currency
     * @param float|null $conversionRate Optional conversion rate
     * @return float
     */
    public function getConvertedUnitPrice($targetCurrency = 'EUR', $conversionRate = null)
    {
        if ($conversionRate !== null) {
            return $this->unit_price * $conversionRate;
        }
        
        $exchangeService = app(CurrencyExchangeService::class);
        $convertedPrice = $exchangeService->convert($this->unit_price, 'EUR', $targetCurrency);
        
        // In case of error, return the original price
        return $convertedPrice ?? $this->unit_price;
    }
    
    /**
     * Gets the total price converted to the target currency
     * 
     * @param string $targetCurrency The target currency
     * @param float|null $conversionRate Optional conversion rate
     * @return float
     */
    public function getConvertedTotalPrice($targetCurrency = 'EUR', $conversionRate = null)
    {
        if ($conversionRate !== null) {
            return $this->total_price * $conversionRate;
        }
        
        $exchangeService = app(CurrencyExchangeService::class);
        $convertedPrice = $exchangeService->convert($this->total_price, 'EUR', $targetCurrency);
        
        // In case of error, return the original price
        return $convertedPrice ?? $this->total_price;
    }
}