<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minister extends Model
{
    use HasFactory;

    protected $table = 'ministers';

    protected $fillable = [
        'name',
        'role',
        'department',
        'bio',
        'photo_path',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];
}

