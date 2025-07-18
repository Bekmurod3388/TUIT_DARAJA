<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramName;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgramNameController extends Controller
{
    /**
     * Display a listing of the program names.
     */
    public function index(): View
    {
        $programNames = ProgramName::orderBy('name')->get();
        return view('admin.program_names.index', compact('programNames'));
    }

    /**
     * Show the form for creating a new program name.
     */
    public function create(): View
    {
        return view('admin.program_names.create');
    }

    /**
     * Store a newly created program name in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:program_names,name'],
            'code' => ['required', 'string', 'max:255', 'unique:program_names,code'],
        ]);
        ProgramName::create($validated);
        return redirect()->route('admin.program-names.index')->with('success', 'Dastur nomi muvaffaqiyatli qo‘shildi.');
    }

    /**
     * Show the form for editing the specified program name.
     */
    public function edit(ProgramName $programName): View
    {
        return view('admin.program_names.edit', compact('programName'));
    }

    /**
     * Update the specified program name in storage.
     */
    public function update(Request $request, ProgramName $programName): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:program_names,name,' . $programName->id],
            'code' => ['required', 'string', 'max:255', 'unique:program_names,code,' . $programName->id],
        ]);
        $programName->update($validated);
        return redirect()->route('admin.program-names.index')->with('success', 'Dastur nomi yangilandi.');
    }

    /**
     * Remove the specified program name from storage.
     */
    public function destroy(ProgramName $programName): RedirectResponse
    {
        $programName->delete();
        return redirect()->route('admin.program-names.index')->with('success', 'Dastur nomi o‘chirildi.');
    }
}
