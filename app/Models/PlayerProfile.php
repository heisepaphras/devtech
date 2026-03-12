<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    protected $fillable = [
        'full_name',
        'slug',
        'jersey_number',
        'date_of_birth',
        'nationality',
        'preferred_foot',
        'primary_position',
        'secondary_position',
        'height_cm',
        'weight_kg',
        'current_team',
        'video_url',
        'summary',
        'bio',
        'strengths',
        'achievements',
        'profile_image',
        'cv_document',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
