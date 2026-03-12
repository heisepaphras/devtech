<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleryItems = GalleryItem::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('captured_at')
            ->orderByDesc('created_at')
            ->paginate(18);

        return view('pages.gallery.index', [
            'pageTitle' => 'Gallery',
            'galleryItems' => $galleryItems,
        ]);
    }
}
