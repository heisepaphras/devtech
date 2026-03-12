<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VideoClip extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'source_url',
        'thumbnail_url',
        'duration_seconds',
        'recorded_at',
        'description',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'recorded_at' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
