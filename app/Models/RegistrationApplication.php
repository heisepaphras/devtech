<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RegistrationApplication extends Model
{
    protected $fillable = [
        'reference_code',
        'full_name',
        'date_of_birth',
        'guardian_name',
        'phone',
        'email',
        'address',
        'age_group',
        'preferred_position',
        'preferred_foot',
        'experience_level',
        'medical_notes',
        'additional_notes',
        'status',
        'review_notes',
        'submitted_at',
        'contacted_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'submitted_at' => 'datetime',
        'contacted_at' => 'datetime',
    ];

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('submitted_at')->orderByDesc('id');
    }
}
