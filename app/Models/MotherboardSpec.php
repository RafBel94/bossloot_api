<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotherboardSpec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'socket',
        'chipset',
        'form_factor',
        'memory_max',
        'memory_slots',
        'memory_type',
        'memory_speed',
        'sata_ports',
        'm_2_slots',
        'pcie_slots',
        'usb_ports',
        'lan',
        'audio',
        'wifi',
        'bluetooth'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
