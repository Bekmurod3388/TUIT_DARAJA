<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Application;
use App\Models\Subject;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $usersCount = User::count();
        $applicationsCount = Application::count();
        $subjects = Subject::all();
        return view('admin.dashboard', compact('user', 'usersCount', 'applicationsCount', 'subjects'));
    }
}
