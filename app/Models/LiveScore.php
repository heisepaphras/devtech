<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LiveScore extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'competition',
        'home_team',
        'home_logo',
        'away_team',
        'away_logo',
        'venue',
        'kickoff_at',
        'home_score',
        'away_score',
        'match_status',
        'live_minute',
        'match_report',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'kickoff_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
