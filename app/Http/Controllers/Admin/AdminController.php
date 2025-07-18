<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Application;
use App\Models\Subject;

class AdminController extends Controller
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
        $user = Auth::user();
        $usersCount = User::count();
        $applicationsCount = Application::count();
        $subjects = Subject::all();
        return view('admin.dashboard', compact('user', 'usersCount', 'applicationsCount', 'subjects'));
    }
}
