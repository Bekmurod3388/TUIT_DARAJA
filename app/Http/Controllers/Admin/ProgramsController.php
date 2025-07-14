<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specalization;

class ProgramsController extends Controller
{
    public function index()
    {
        $programs = Specalization::all();
        return view('admin.programs', compact('programs'));
    }

    public function create()
    {
        return view('admin.create-program');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:specalizations,code',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        Specalization::create($validated);
        return redirect()->route('admin.programs')->with('success', 'Dastur yaratildi!');
    }

    public function edit($id)
    {
        $program = Specalization::findOrFail($id);
        return view('admin.edit-program', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:specalizations,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'is_visible' => 'nullable|boolean',
        ]);
        $validated['is_visible'] = (int) $request->input('is_visible', 0);
        $program = Specalization::findOrFail($id);
        $program->update($validated);
        return redirect()->route('admin.programs')->with('success', 'Dastur yangilandi!');
    }
}
