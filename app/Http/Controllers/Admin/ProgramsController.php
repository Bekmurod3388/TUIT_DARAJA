<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specalization;
use App\Models\Subject;
use App\Http\Requests\ProgramRequest;
use App\Models\ProgramName;

class ProgramsController extends Controller
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
        $programs = Specalization::all();
        return view('admin.programs', compact('programs'));
    }

    public function create()
    {
        $subjects = \App\Models\Subject::all();
        $programNames = \App\Models\ProgramName::all();
        return view('admin.create-program', compact('subjects', 'programNames'));
    }

    public function store(ProgramRequest $request)
    {
        $validated = $request->validated();
        $programName = ProgramName::findOrFail($validated['program_name_id']);
        $program = Specalization::create([
            'program_name_id' => $programName->id,
            'name' => $programName->name,
            'code' => $programName->code,
            'price' => $validated['price'],
            'description' => $validated['description'],
            'is_visible' => $request->has('is_visible') ? $request->boolean('is_visible') : true,
        ]);
        $program->subjects()->sync($validated['subjects']);
        return redirect()->route('admin.programs')->with('success', 'Dastur yaratildi!');
    }

    public function edit($id)
    {
        $program = Specalization::findOrFail($id);
        $subjects = \App\Models\Subject::all();
        $programNames = \App\Models\ProgramName::all();
        $selectedSubjects = $program->subjects->pluck('fan_id')->toArray();
        return view('admin.edit-program', compact('program', 'subjects', 'selectedSubjects', 'programNames'));
    }

    public function update(Request $request, $id)
    {
        $program = Specalization::findOrFail($id);

        // Faqat is_visible ni o'zgartirish uchun (masalan, ko'rsatish tugmasi)
        if ($request->has('is_visible') && count($request->all()) <= 3) { // _token, is_visible, _method
            $program->is_visible = $request->boolean('is_visible');
            $program->save();
            return redirect()->route('admin.programs')->with('success', 'Ko‘rsatish holati yangilandi!');
        }

        // To'liq update uchun
        $validated = $request->validate([
            'program_name_id' => 'required|exists:program_names,id',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,fan_id',
            'is_visible' => 'nullable|boolean',
        ]);
        $programName = ProgramName::findOrFail($validated['program_name_id']);
        $program->update([
            'program_name_id' => $programName->id,
            'name' => $programName->name,
            'code' => $programName->code,
            'price' => $validated['price'],
            'description' => $validated['description'],
            'is_visible' => $request->boolean('is_visible'),
        ]);
        $program->subjects()->sync($validated['subjects']);
        return redirect()->route('admin.programs')->with('success', 'Dastur yangilandi!');
    }

    public function destroy($id)
    {
        $program = Specalization::findOrFail($id);
        $program->delete();
        return redirect()->route('admin.programs')->with('success', 'Dastur o‘chirildi!');
    }
}
