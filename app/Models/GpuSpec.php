<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpuSpec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'memory',
        'memory_type',
        'core_clock',
        'boost_clock',
        'consumption',
        'length'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
