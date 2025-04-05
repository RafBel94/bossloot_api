<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsuSpec extends Model
{
    /** @use HasFactory<\Database\Factories\PsuSpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'efficiency_rating',
        'wattage',
        'modular',
        'fanless',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
