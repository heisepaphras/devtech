<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'event_type',
        'venue',
        'summary',
        'description',
        'starts_at',
        'ends_at',
        'registration_link',
        'featured_image',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
