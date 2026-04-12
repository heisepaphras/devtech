<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSettings extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'hero_kicker',
        'hero_title',
        'hero_copy',
        'hero_metric_1',
        'hero_metric_2',
        'hero_metric_3',
        'hero_trials_label',
        'hero_trials_date',
        'hero_trials_location',
        'hero_main_image',
        'hero_thumb_1',
        'hero_thumb_2',
        'visual_kicker',
        'visual_title',
        'visual_description',
        'visual_card_1_image',
        'visual_card_1_title',
        'visual_card_1_description',
        'visual_card_2_image',
        'visual_card_2_title',
        'visual_card_2_description',
        'visual_card_3_image',
        'visual_card_3_title',
        'visual_card_3_description',
    ];

    /**
     * Return the single settings row, creating it if missing.
     */
    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
