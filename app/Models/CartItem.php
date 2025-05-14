<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Product;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];
    
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function updateTotalPrice()
    {
        $this->total_price = $this->quantity * $this->unit_price;
        $this->save();
        
        return $this;
    }
}