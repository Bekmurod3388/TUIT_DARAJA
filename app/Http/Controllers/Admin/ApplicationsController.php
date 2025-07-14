<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends Controller
{
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

    public function show($id)
    {
        $application = \App\Models\Application::with(['user', 'specalization'])->findOrFail($id);
        return view('admin.applications-show', compact('application'));
    }
}
