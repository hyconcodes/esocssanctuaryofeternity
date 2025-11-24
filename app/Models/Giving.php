<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giving extends Model
{
    use HasFactory;

    protected $table = 'givings';

    protected $fillable = [
        'account_number',
        'account_name',
        'bank_name',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
