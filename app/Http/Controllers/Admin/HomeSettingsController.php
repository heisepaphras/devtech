<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\View\View;

class HomeSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.home-settings.edit', [
            'pageTitle' => 'Home Page Settings',
            'settings' => HomeSettings::instance(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_kicker'              => ['required', 'string', 'max:255'],
            'hero_title'               => ['required', 'string', 'max:255'],
            'hero_copy'                => ['required', 'string'],
            'hero_metric_1'            => ['required', 'string', 'max:255'],
            'hero_metric_2'            => ['required', 'string', 'max:255'],
            'hero_metric_3'            => ['required', 'string', 'max:255'],
            'hero_trials_label'        => ['required', 'string', 'max:255'],
            'hero_trials_date'         => ['required', 'string', 'max:255'],
            'hero_trials_location'     => ['required', 'string', 'max:255'],
            'hero_main_image'          => ['nullable', 'image', 'max:4096'],
            'hero_thumb_1'             => ['nullable', 'image', 'max:4096'],
            'hero_thumb_2'             => ['nullable', 'image', 'max:4096'],
            'visual_kicker'            => ['required', 'string', 'max:255'],
            'visual_title'             => ['required', 'string', 'max:255'],
            'visual_description'       => ['required', 'string', 'max:255'],
            'visual_card_1_image'      => ['nullable', 'image', 'max:4096'],
            'visual_card_1_title'      => ['required', 'string', 'max:255'],
            'visual_card_1_description'=> ['required', 'string', 'max:255'],
            'visual_card_2_image'      => ['nullable', 'image', 'max:4096'],
            'visual_card_2_title'      => ['required', 'string', 'max:255'],
            'visual_card_2_description'=> ['required', 'string', 'max:255'],
            'visual_card_3_image'      => ['nullable', 'image', 'max:4096'],
            'visual_card_3_title'      => ['required', 'string', 'max:255'],
            'visual_card_3_description'=> ['required', 'string', 'max:255'],
        ]);

        $settings = HomeSettings::instance();

        // Handle image uploads
        $imageFields = [
            'hero_main_image',
            'hero_thumb_1',
            'hero_thumb_2',
            'visual_card_1_image',
            'visual_card_2_image',
            'visual_card_3_image',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image
                if ($settings->$field) {
                    CloudinaryUploader::deleteImage($settings->$field);
                }
                $validated[$field] = CloudinaryUploader::uploadImage($request->file($field), 'home');
            } else {
                // Keep existing value
                unset($validated[$field]);
            }
        }

        $settings->fill($validated)->save();

        return redirect()
            ->route('admin.home-settings.edit')
            ->with('status', 'Home page settings updated successfully.');
    }
}
