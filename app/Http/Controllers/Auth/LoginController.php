<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->merge([
            'phone' => \App\Models\User::normalizePhone($request->input('phone')),
        ]);

        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['phone' => $credentials['phone'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/my-applications');
        }

        return back()->withErrors([
            'phone' => 'Telefon raqami yoki parol noto‘g‘ri.',
        ])->withInput($request->only('phone'));
    }
}
