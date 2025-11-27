<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'flyer_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

