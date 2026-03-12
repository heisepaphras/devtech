<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ScoutingProgram extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'age_group',
        'schedule',
        'duration_weeks',
        'capacity',
        'registration_link',
        'featured_image',
        'fee',
        'description',
        'highlights',
        'requirements',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
