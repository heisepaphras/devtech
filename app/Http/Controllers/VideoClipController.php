<?php

namespace App\Http\Controllers;

use App\Models\VideoClip;
use Illuminate\View\View;

class VideoClipController extends Controller
{
    public function index(): View
    {
        $featuredVideos = VideoClip::query()
            ->published()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderByDesc('recorded_at')
            ->limit(4)
            ->get();

        $videoClips = VideoClip::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('recorded_at')
            ->paginate(12);

        return view('pages.videos.index', [
            'pageTitle' => 'Video Clips',
            'featuredVideos' => $featuredVideos,
            'videoClips' => $videoClips,
        ]);
    }

    public function show(string $slug): View
    {
        $videoClip = VideoClip::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedVideos = VideoClip::query()
            ->published()
            ->where('id', '!=', $videoClip->id)
            ->where('category', $videoClip->category)
            ->orderByDesc('recorded_at')
            ->limit(4)
            ->get();

        return view('pages.videos.show', [
            'pageTitle' => $videoClip->title,
            'videoClip' => $videoClip,
            'relatedVideos' => $relatedVideos,
        ]);
    }
}
