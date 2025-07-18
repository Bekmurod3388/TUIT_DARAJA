<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                abort(403, 'Sizda admin panelga kirish huquqi yo‘q.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $applications = Application::with(['user', 'specalization'])->get();
        return view('admin.applications', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,in_process,cancelled',
        ]);
        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();
        return redirect()->back()->with('success', 'Ariza statusi yangilandi!');
    }

    public function setScore(Request $request, $id)
    {
        $application = \App\Models\Application::findOrFail($id);
        $data = $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);
        $application->score = $data['score'];
        $application->is_scored = true;
        $application->save();
        return redirect()->back()->with('success', 'Ball qo‘yildi!');
    }

    public function show($id)
    {
        $application = \App\Models\Application::with(['user', 'specalization'])->findOrFail($id);
        return view('admin.applications-show', compact('application'));
    }
}
