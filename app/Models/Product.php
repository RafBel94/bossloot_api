<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'model',
        'brand',
        'price',
        'quantity',
        'on_sale',
        'featured',
        'image'
    ];

    public function specs()
    {
        return match($this->category) {
            'ram' => $this->hasOne(RamSpec::class),
            'gpu' => $this->hasOne(GpuSpec::class),
            'cpu' => $this->hasOne(CpuSpec::class),
            'motherboard' => $this->hasOne(MotherboardSpec::class),
            'storage' => $this->hasOne(StorageSpec::class),
            'psu' => $this->hasOne(PsuSpec::class),
            'case' => $this->hasOne(CaseSpec::class),
            'cooler' => $this->hasOne(CoolerSpec::class),
            'display' => $this->hasOne(DisplaySpec::class),
            'keyboard' => $this->hasOne(KeyboardSpec::class),
            'mouse' => $this->hasOne(MouseSpec::class),
            default => null,
        };
    }
}
