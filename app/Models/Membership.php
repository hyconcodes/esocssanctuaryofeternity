<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';

    protected $fillable = [
        'email',
        'name',
        'priesthood_office',
        'phone1',
        'phone2',
        'relation_or_caregiver',
        'dob',
        'address',
        'city',
        'state',
        'country',
        'occupation',
        'occupation_other',
        'relationship_status',
        'spouse_name',
        'children_count',
        'membership_year',
        'membership_id',
        'faith_grad_date',
        'faith_department',
    ];

    protected $casts = [
        'dob' => 'date',
        'faith_grad_date' => 'date',
        'children_count' => 'integer',
    ];
}

