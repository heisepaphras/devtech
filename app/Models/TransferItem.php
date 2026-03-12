<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TransferItem extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'player_name',
        'position',
        'transfer_type',
        'from_club',
        'to_club',
        'transfer_fee',
        'player_image',
        'contract_until',
        'summary',
        'details',
        'announced_at',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'announced_at' => 'datetime',
        'contract_until' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
