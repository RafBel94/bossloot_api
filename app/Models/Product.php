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
        $relations = [
            'ram' => $this->ramSpec(),
            'gpu' => $this->gpuSpec(),
            'cpu' => $this->cpuSpec(),
            'motherboard' => $this->motherboardSpec(),
            'storage' => $this->storageSpec(),
            'psu' => $this->psuSpec(),
            'case' => $this->caseSpec(),
            'cooler' => $this->coolerSpec(),
            'display' => $this->displaySpec(),
            'keyboard' => $this->keyboardSpec(),
            'mouse' => $this->mouseSpec(),
        ];

        return $relations[$this->category] ?? null;
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
}
