<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $table = 'testimonies';

    protected $fillable = [
        'title',
        'description',
        'category',
        'author',
        'author_photo_path',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
