<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpuSpec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'socket',
        'core_count',
        'thread_count',
        'base_clock',
        'boost_clock',
        'consumption',
        'integrated_graphics'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
