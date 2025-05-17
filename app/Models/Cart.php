<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'currency'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    // Method for updating the total amount of the cart
    public function updateTotal()
    {
        $this->load('items');
        $this->load('user');
        $discount = $this->user->getDiscount();
        $this->total_amount = $this->items->sum('total_price') - ($this->items->sum('total_price') * $discount);
        $this->save();
        
        return $this;
    }
}