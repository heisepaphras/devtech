<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const STATUSES = ['new', 'reviewing', 'accepted', 'waitlisted', 'rejected'];

    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');

        $applications = RegistrationApplication::query()
            ->when(
                in_array($statusFilter, self::STATUSES, true),
                fn ($query) => $query->where('status', $statusFilter)
            )
            ->latestFirst()
            ->paginate(20)
            ->withQueryString();

        return view('admin.registrations.index', [
            'pageTitle' => 'Manage Registrations',
            'applications' => $applications,
            'statusFilter' => $statusFilter,
            'statuses' => self::STATUSES,
        ]);
    }

    public function edit(RegistrationApplication $registrationApplication): View
    {
        return view('admin.registrations.edit', [
            'pageTitle' => 'Review Registration',
            'application' => $registrationApplication,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, RegistrationApplication $registrationApplication): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
            'review_notes' => ['nullable', 'string', 'max:3000'],
            'mark_contacted' => ['nullable', 'boolean'],
        ]);

        $registrationApplication->status = $validated['status'];
        $registrationApplication->review_notes = $validated['review_notes'] ?? null;
        $registrationApplication->contacted_at = $request->boolean('mark_contacted')
            ? ($registrationApplication->contacted_at ?? now())
            : null;
        $registrationApplication->save();

        return redirect()
            ->route('admin.registrations.index')
            ->with('status', 'Registration updated successfully.');
    }

    public function destroy(RegistrationApplication $registrationApplication): RedirectResponse
    {
        $registrationApplication->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with('status', 'Registration deleted successfully.');
    }
}
