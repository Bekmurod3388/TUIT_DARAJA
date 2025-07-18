<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;

class SubjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                abort(403, 'Sizda fanlar bo‘limiga kirish huquqi yo‘q.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects', compact('subjects'));
    }

    public function create()
    {
        return view('admin.create-subject');
    }

    public function store(SubjectRequest $request)
    {
        $validated = $request->validated();
        \App\Models\Subject::create($validated);
        return redirect()->route('admin.subjects')->with('success', 'Fan yaratildi!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.edit-subject', compact('subject'));
    }

    public function update(SubjectRequest $request, $id)
    {
        $validated = $request->validated();
        $subject = \App\Models\Subject::findOrFail($id);
        $subject->update($validated);
        return redirect()->route('admin.subjects')->with('success', 'Fan yangilandi!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('admin.subjects')->with('success', 'Fan o‘chirildi!');
    }
}
