<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected static function boot()
{
    parent::boot();

    static::deleting(function($brand) {
        $brand->products()->update(['brand_id' => 1]);
        \Log::info("Borrando marca ID: {$brand->id}, productos afectados: " . $brand->products()->count());
    });
}

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
