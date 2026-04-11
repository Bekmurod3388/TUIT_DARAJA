<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AcademicYear;
use App\Models\Specalization;

class ProgramsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeAcademicYear = AcademicYear::query()->where('is_active', true)->first();
        $programs = Specalization::query()
            ->with(['subjects', 'academicYear'])
            ->where('is_visible', true)
            ->when($activeAcademicYear, fn ($query) => $query->where('academic_year_id', $activeAcademicYear->id))
            ->get();

        return view('programs', compact('user', 'programs'));
    }
}
