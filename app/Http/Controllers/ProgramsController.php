<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Specalization;

class ProgramsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $programs = \App\Models\Specalization::where('is_visible', true)->get();
        return view('programs', compact('user', 'programs'));
    }
}
