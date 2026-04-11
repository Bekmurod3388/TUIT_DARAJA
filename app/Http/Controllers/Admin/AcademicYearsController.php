<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearRequest;
use App\Models\AcademicYear;

class AcademicYearsController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::query()
            ->orderByDesc('name')
            ->orderByRaw("CASE WHEN semester = 'bahorgi' THEN 0 ELSE 1 END")
            ->get();

        return view('admin.academic-years', compact('academicYears'));
    }

    public function create()
    {
        return view('admin.create-academic-year');
    }

    public function store(AcademicYearRequest $request)
    {
        $academicYear = AcademicYear::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active') || !AcademicYear::query()->where('is_active', true)->exists(),
        ]);

        $this->syncActiveAcademicYear($academicYear, $academicYear->is_active);

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'O\'quv yili yaratildi!');
    }

    public function edit($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        return view('admin.edit-academic-year', compact('academicYear'));
    }

    public function update(AcademicYearRequest $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $shouldBeActive = $request->boolean('is_active');

        if (!$shouldBeActive) {
            $hasAnotherActiveYear = AcademicYear::query()
                ->whereKeyNot($academicYear->id)
                ->where('is_active', true)
                ->exists();

            $shouldBeActive = !$hasAnotherActiveYear;
        }

        $academicYear->update([
            ...$request->validated(),
            'is_active' => $shouldBeActive,
        ]);

        $this->syncActiveAcademicYear($academicYear, $academicYear->is_active);

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'O\'quv yili yangilandi!');
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $wasActive = (bool) $academicYear->is_active;
        $academicYear->delete();

        if ($wasActive) {
            $replacement = AcademicYear::query()->latest('id')->first();

            if ($replacement) {
                $this->syncActiveAcademicYear($replacement, true);
            }
        }

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'O\'quv yili o\'chirildi!');
    }

    private function syncActiveAcademicYear(AcademicYear $academicYear, bool $shouldActivate): void
    {
        if (!$shouldActivate) {
            return;
        }

        AcademicYear::query()
            ->whereKeyNot($academicYear->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }
}
