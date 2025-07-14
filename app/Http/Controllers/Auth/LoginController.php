<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Telefon raqamidan faqat raqamlarni qoldiramiz
        $cleanPhone = preg_replace('/\D/', '', $credentials['phone']);

        if (Auth::attempt(['phone' => $cleanPhone, 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/my-applications');
        }

        return back()->withErrors([
            'phone' => 'Telefon raqami yoki parol noto‘g‘ri.',
        ])->withInput($request->only('phone'));
    }
}
