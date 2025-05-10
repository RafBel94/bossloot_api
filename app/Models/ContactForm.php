<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'image',
        'status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_RESOLVED = 'answered';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
