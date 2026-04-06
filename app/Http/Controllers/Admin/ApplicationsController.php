<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends Controller
{
    public function index()
    {
        $applications = Application::with(['user', 'specalization'])->latest()->get();
        return view('admin.applications', compact('applications'));
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
        $application = Application::with(['user', 'specalization'])->findOrFail($id);
        return view('admin.applications-show', compact('application'));
    }
}
