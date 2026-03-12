<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::query()
            ->published()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('pages.news.index', [
            'pageTitle' => 'News',
            'newsItems' => $newsItems,
        ]);
    }

    public function show(string $slug): View
    {
        $news = News::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::query()
            ->published()
            ->where('id', '!=', $news->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.news.show', [
            'pageTitle' => $news->title,
            'news' => $news,
            'relatedNews' => $relatedNews,
        ]);
    }
}
