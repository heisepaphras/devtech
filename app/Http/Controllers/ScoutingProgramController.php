<?php

namespace App\Http\Controllers;

use App\Models\ScoutingProgram;
use Illuminate\View\View;

class ScoutingProgramController extends Controller
{
    public function index(): View
    {
        $programs = ScoutingProgram::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('pages.programs.index', [
            'pageTitle' => 'Scouting and Trials Programs',
            'programs' => $programs,
        ]);
    }

    public function show(string $slug): View
    {
        $program = ScoutingProgram::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPrograms = ScoutingProgram::query()
            ->published()
            ->where('id', '!=', $program->id)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('pages.programs.show', [
            'pageTitle' => $program->title,
            'program' => $program,
            'relatedPrograms' => $relatedPrograms,
        ]);
    }
}
