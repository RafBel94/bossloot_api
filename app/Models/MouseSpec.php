<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouseSpec extends Model
{
    /** @use HasFactory<\Database\Factories\MouseSpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'dpi',
        'sensor',
        'buttons',
        'bluetooth',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
