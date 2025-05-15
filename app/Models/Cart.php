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
    
    // Método para actualizar el total
    public function updateTotal()
    {
        $this->load('items');
        $this->total_amount = $this->items->sum('total_price');
        $this->save();
        
        return $this;
    }
}