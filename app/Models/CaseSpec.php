<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseSpec extends Model
{
    /** @use HasFactory<\Database\Factories\CaseSpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'case_type',
        'form_factor_support',
        'tempered_glass',
        'expansion_slots',
        'max_gpu_length',
        'max_cpu_cooler_height',
        'radiator_support',
        'extra_fans_connectors',
        'depth',
        'width',
        'height',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
