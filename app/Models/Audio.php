<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios';

    protected $fillable = [
        'title',
        'description',
        'category',
        'audio_path',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
