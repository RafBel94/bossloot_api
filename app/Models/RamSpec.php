<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamSpec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'speed',
        'memory',
        'memory_type',
        'latency'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
