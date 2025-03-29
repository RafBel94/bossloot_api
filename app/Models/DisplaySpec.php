<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplaySpec extends Model
{
    /** @use HasFactory<\Database\Factories\DisplaySpecFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'resolution',
        'refresh_rate',
        'response_time',
        'panel_type',
        'aspect_ratio',
        'curved',
        'brightness',
        'contrast_ratio',
        'sync_type',
        'hdmi_ports',
        'display_ports',
        'inches',
        'weight',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
