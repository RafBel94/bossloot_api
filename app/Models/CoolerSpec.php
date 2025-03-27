<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoolerSpec extends Model
{
    /** @use HasFactory<\Database\Factories\CoolerSpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'fan_rpm',
        'consumption',
        'socket_support',
        'width',
        'height',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
