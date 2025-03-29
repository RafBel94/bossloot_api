<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyboardSpec extends Model
{
    /** @use HasFactory<\Database\Factories\KeyboardSpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'switch_type',
        'width',
        'height',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
