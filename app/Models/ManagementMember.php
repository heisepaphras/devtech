<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ManagementMember extends Model
{
    protected $fillable = [
        'full_name',
        'slug',
        'role_title',
        'department',
        'email',
        'phone',
        'bio',
        'image_path',
        'experience_years',
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
