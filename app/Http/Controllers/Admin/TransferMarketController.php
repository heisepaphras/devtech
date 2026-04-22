<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransferItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransferMarketController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const TRANSFER_TYPES = [
        'incoming',
        'outgoing',
        'trial',
        'promotion',
        'contract-extension',
        'released',
    ];

    public function index(): View
    {
        $transferItems = TransferItem::query()
            ->orderByDesc('announced_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.transfers.index', [
            'pageTitle' => 'Manage Transfer Market',
            'transferItems' => $transferItems,
        ]);
    }

    public function create(): View
    {
        return view('admin.transfers.create', [
            'pageTitle' => 'Create Transfer Update',
            'transferItem' => new TransferItem([
                'is_published' => true,
                'announced_at' => now(),
                'transfer_type' => 'incoming',
            ]),
            'transferTypes' => self::TRANSFER_TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $transferItem = new TransferItem();
        $this->saveTransferItem($transferItem, $validated, $request);

        return redirect()
            ->route('admin.transfers.index')
            ->with('status', 'Transfer update created successfully.');
    }

    public function edit(TransferItem $transferItem): View
    {
        return view('admin.transfers.edit', [
            'pageTitle' => 'Edit Transfer Update',
            'transferItem' => $transferItem,
            'transferTypes' => self::TRANSFER_TYPES,
        ]);
    }

    public function update(Request $request, TransferItem $transferItem): RedirectResponse
    {
        $validated = $this->validatePayload($request, $transferItem->id);

        $this->saveTransferItem($transferItem, $validated, $request);

        return redirect()
            ->route('admin.transfers.index')
            ->with('status', 'Transfer update saved successfully.');
    }

    public function destroy(TransferItem $transferItem): RedirectResponse
    {
        if ($transferItem->player_image) {
            CloudinaryUploader::deleteImage($transferItem->player_image);
        }

        $transferItem->delete();

        return redirect()
            ->route('admin.transfers.index')
            ->with('status', 'Transfer update deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $transferId): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('transfer_items', 'slug')->ignore($transferId),
            ],
            'player_name' => ['required', 'string', 'max:120'],
            'position' => ['nullable', 'string', 'max:80'],
            'transfer_type' => ['required', Rule::in(self::TRANSFER_TYPES)],
            'from_club' => ['nullable', 'string', 'max:160'],
            'to_club' => ['nullable', 'string', 'max:160'],
            'transfer_fee' => ['nullable', 'string', 'max:80'],
            'player_image' => ['nullable', 'image', 'max:4096'],
            'contract_until' => ['nullable', 'date'],
            'summary' => ['nullable', 'string', 'max:320'],
            'details' => ['nullable', 'string', 'max:3000'],
            'announced_at' => ['required', 'date'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveTransferItem(TransferItem $transferItem, array $validated, Request $request): void
    {
        $transferItem->title = $validated['title'];
        $transferItem->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'] . '-' . $validated['player_name'],
            $transferItem->id
        );
        $transferItem->player_name = $validated['player_name'];
        $transferItem->position = $validated['position'] ?? null;
        $transferItem->transfer_type = $validated['transfer_type'];
        $transferItem->from_club = $validated['from_club'] ?? null;
        $transferItem->to_club = $validated['to_club'] ?? null;
        $transferItem->transfer_fee = $validated['transfer_fee'] ?? null;
        if ($request->hasFile('player_image')) {
            if ($transferItem->player_image) {
                CloudinaryUploader::deleteImage($transferItem->player_image);
            }

            $transferItem->player_image = CloudinaryUploader::uploadImage($request->file('player_image'), 'transfers');
        }
        $transferItem->contract_until = $validated['contract_until'] ?? null;
        $transferItem->summary = $validated['summary'] ?? null;
        $transferItem->details = $validated['details'] ?? null;
        $transferItem->announced_at = $validated['announced_at'];
        $transferItem->sort_order = $validated['sort_order'] ?? 0;
        $transferItem->is_featured = $request->boolean('is_featured');
        $transferItem->is_published = $request->boolean('is_published');
        $transferItem->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'transfer-item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            TransferItem::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
