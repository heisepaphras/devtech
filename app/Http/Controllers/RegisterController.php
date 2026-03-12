<?php

namespace App\Http\Controllers;

use App\Models\RegistrationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const AGE_GROUPS = [
        'U8-U10',
        'U11-U13',
        'U14-U16',
        'U17-U20',
    ];

    public function create(): View
    {
        return view('pages.register.index', [
            'pageTitle' => 'Register Now',
            'ageGroups' => self::AGE_GROUPS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:140'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'guardian_name' => ['nullable', 'string', 'max:140'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'address' => ['nullable', 'string', 'max:255'],
            'age_group' => ['nullable', 'string', 'max:40'],
            'preferred_position' => ['nullable', 'string', 'max:80'],
            'preferred_foot' => ['nullable', 'string', 'max:20'],
            'experience_level' => ['nullable', 'string', 'max:80'],
            'medical_notes' => ['nullable', 'string', 'max:2000'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $application = new RegistrationApplication();
        $application->reference_code = $this->generateReferenceCode();
        $application->full_name = $validated['full_name'];
        $application->date_of_birth = $validated['date_of_birth'] ?? null;
        $application->guardian_name = $validated['guardian_name'] ?? null;
        $application->phone = $validated['phone'];
        $application->email = $validated['email'] ?? null;
        $application->address = $validated['address'] ?? null;
        $application->age_group = $validated['age_group'] ?? null;
        $application->preferred_position = $validated['preferred_position'] ?? null;
        $application->preferred_foot = $validated['preferred_foot'] ?? null;
        $application->experience_level = $validated['experience_level'] ?? null;
        $application->medical_notes = $validated['medical_notes'] ?? null;
        $application->additional_notes = $validated['additional_notes'] ?? null;
        $application->status = 'new';
        $application->submitted_at = now();
        $application->save();

        return redirect()
            ->route('register')
            ->with('status', 'Application submitted successfully. Reference: ' . $application->reference_code);
    }

    private function generateReferenceCode(): string
    {
        do {
            $code = 'AKFA-' . now()->format('ymd') . '-' . Str::upper(Str::random(5));
        } while (
            RegistrationApplication::query()
                ->where('reference_code', $code)
                ->exists()
        );

        return $code;
    }
}
