<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerValue extends Model
{
    protected $fillable = [
        'player_profile_id',
        'player_name_snapshot',
        'player_image',
        'slug',
        'value_ngn',
        'previous_value_ngn',
        'value_change',
        'assessment_note',
        'assessed_at',
        'assessor_name',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'assessed_at' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function playerProfile(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
