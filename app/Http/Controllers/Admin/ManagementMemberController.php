<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ManagementMemberController extends Controller
{
    public function index(): View
    {
        $managementMembers = ManagementMember::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(20);

        return view('admin.management.index', [
            'pageTitle' => 'Manage Management Team',
            'managementMembers' => $managementMembers,
        ]);
    }

    public function create(): View
    {
        return view('admin.management.create', [
            'pageTitle' => 'Create Management Member',
            'managementMember' => new ManagementMember([
                'is_published' => true,
                'department' => 'Management',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $managementMember = new ManagementMember();
        $this->saveManagementMember($managementMember, $validated, $request);

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Management member created successfully.');
    }

    public function edit(ManagementMember $managementMember): View
    {
        return view('admin.management.edit', [
            'pageTitle' => 'Edit Management Member',
            'managementMember' => $managementMember,
        ]);
    }

    public function update(Request $request, ManagementMember $managementMember): RedirectResponse
    {
        $validated = $this->validatePayload($request, $managementMember->id);

        $this->saveManagementMember($managementMember, $validated, $request);

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Management member updated successfully.');
    }

    public function destroy(ManagementMember $managementMember): RedirectResponse
    {
        if ($managementMember->image_path) {
            Storage::disk('public')->delete($managementMember->image_path);
        }

        $managementMember->delete();

        return redirect()
            ->route('admin.management.index')
            ->with('status', 'Management member deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $memberId): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:140'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('management_members', 'slug')->ignore($memberId),
            ],
            'role_title' => ['required', 'string', 'max:120'],
            'department' => ['nullable', 'string', 'max:80'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'experience_years' => ['nullable', 'integer', 'between:0,60'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveManagementMember(ManagementMember $managementMember, array $validated, Request $request): void
    {
        $managementMember->full_name = $validated['full_name'];
        $managementMember->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['full_name'],
            $managementMember->id
        );
        $managementMember->role_title = $validated['role_title'];
        $managementMember->department = $validated['department'] ?? null;
        $managementMember->email = $validated['email'] ?? null;
        $managementMember->phone = $validated['phone'] ?? null;
        $managementMember->bio = $validated['bio'] ?? null;
        $managementMember->experience_years = $validated['experience_years'] ?? null;
        $managementMember->sort_order = $validated['sort_order'] ?? 0;
        $managementMember->is_featured = $request->boolean('is_featured');
        $managementMember->is_published = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($managementMember->image_path) {
                Storage::disk('public')->delete($managementMember->image_path);
            }

            $managementMember->image_path = $request->file('image')->store('management', 'public');
        }

        $managementMember->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'management-member';
        $slug = $baseSlug;
        $counter = 1;

        while (
            ManagementMember::query()
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
