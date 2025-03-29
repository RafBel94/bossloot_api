<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageSpec extends Model
{
    /** @use HasFactory<\Database\Factories\StorageSpecFactory> */
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'type',
        'capacity',
        'rpm',
        'read_speed',
        'write_speed'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
