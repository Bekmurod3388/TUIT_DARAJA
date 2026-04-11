<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'academic_year_name' => $request->string('academic_year_name')->toString(),
            'semester' => $request->string('semester')->toString(),
        ];

        $applications = Application::with(['user', 'specalization', 'academicYear'])
            ->when($filters['academic_year_name'] !== '', function ($query) use ($filters) {
                $query->whereHas('academicYear', fn ($academicYearQuery) => $academicYearQuery
                    ->where('name', $filters['academic_year_name']));
            })
            ->when($filters['semester'] !== '', function ($query) use ($filters) {
                $query->whereHas('academicYear', fn ($academicYearQuery) => $academicYearQuery
                    ->where('semester', $filters['semester']));
            })
            ->latest()
            ->get();

        $academicYearNames = AcademicYear::query()
            ->select('name')
            ->distinct()
            ->orderByDesc('name')
            ->pluck('name');

        return view('admin.applications', compact('applications', 'academicYearNames', 'filters'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,in_process,cancelled',
        ]);

        $application = Application::findOrFail($id);
        $oldStatus = $application->status;
        $application->status = $request->status;
        $application->save();

        AuditLog::record('status_changed', $application, ['status' => $oldStatus], ['status' => $request->status]);

        return redirect()->back()->with('success', 'Ariza statusi yangilandi!');
    }

    public function setScore(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $data = $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);

        $oldScore = $application->score;
        $application->score = $data['score'];
        $application->is_scored = true;
        $application->save();

        AuditLog::record('score_set', $application, ['score' => $oldScore], ['score' => $data['score']]);

        return redirect()->back()->with('success', 'Ball qo\'yildi!');
    }

    public function show($id)
    {
        $application = Application::with(['user', 'specalization', 'academicYear'])->findOrFail($id);
        return view('admin.applications-show', compact('application'));
    }
}
