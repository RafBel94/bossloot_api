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
        'model',
        'price',
        'quantity',
        'on_offer',
        'discount',
        'featured',
        'image',
        'deleted'
    ];

    public function specs()
    {

        $categoryToSpecMap = [
            1 => 'ram',
            2 => 'gpu',
            3 => 'cpu',
            4 => 'motherboard',
            5 => 'storage',
            6 => 'psu',
            7 => 'case',
            8 => 'cooler',
            9 => 'display',
            10 => 'keyboard',
            11 => 'mouse',
        ];

        $specType = $categoryToSpecMap[$this->category_id] ?? null;

        if (!$specType) {
            return null;
        }

        return $this->{"{$specType}Spec"}();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function ramSpec()
    {
        return $this->hasOne(RamSpec::class);
    }

    public function gpuSpec()
    {
        return $this->hasOne(GpuSpec::class);
    }
    public function cpuSpec()
    {
        return $this->hasOne(CpuSpec::class);
    }

    public function motherboardSpec()
    {
        return $this->hasOne(MotherboardSpec::class);
    }

    public function storageSpec()
    {
        return $this->hasOne(StorageSpec::class);
    }

    public function psuSpec()
    {
        return $this->hasOne(PsuSpec::class);
    }

    public function caseSpec()
    {
        return $this->hasOne(CaseSpec::class);
    }

    public function coolerSpec()
    {
        return $this->hasOne(CoolerSpec::class);
    }

    public function displaySpec()
    {
        return $this->hasOne(DisplaySpec::class);
    }

    public function keyboardSpec()
    {
        return $this->hasOne(KeyboardSpec::class);
    }

    public function mouseSpec()
    {
        return $this->hasOne(MouseSpec::class);
    }

    public function valorations()
    {
        return $this->hasMany(Valoration::class);
    }

    public function averageRating(): float
    {
        return $this->valorations()->avg('rating') ?? 0;
    }

    public function totalLikes()
    {
        return $this->valorations()->sum('likes') ?? 0;
    }

    public function totalDislikes()
    {
        return $this->valorations()->sum('dislikes') ?? 0;
    }

    public function totalValorationCount()
    {
        return $this->valorations()->count() ?? 0;
    }
}
