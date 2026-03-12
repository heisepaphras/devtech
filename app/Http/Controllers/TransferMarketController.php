<?php

namespace App\Http\Controllers;

use App\Models\TransferItem;
use Illuminate\View\View;

class TransferMarketController extends Controller
{
    public function index(): View
    {
        $featuredTransfers = TransferItem::query()
            ->published()
            ->where('is_featured', true)
            ->orderByDesc('announced_at')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $transferItems = TransferItem::query()
            ->published()
            ->orderByDesc('announced_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.transfers.index', [
            'pageTitle' => 'Transfer Market',
            'featuredTransfers' => $featuredTransfers,
            'transferItems' => $transferItems,
        ]);
    }

    public function show(string $slug): View
    {
        $transferItem = TransferItem::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedTransfers = TransferItem::query()
            ->published()
            ->where('id', '!=', $transferItem->id)
            ->where('transfer_type', $transferItem->transfer_type)
            ->orderByDesc('announced_at')
            ->limit(3)
            ->get();

        return view('pages.transfers.show', [
            'pageTitle' => $transferItem->title,
            'transferItem' => $transferItem,
            'relatedTransfers' => $relatedTransfers,
        ]);
    }
}
