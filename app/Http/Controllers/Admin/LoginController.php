<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Handles admin authentication (login form and login logic).
 */
class LoginController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    /**
     * Handle an admin login request.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string', 'max:19'],
            'password' => ['required', 'string'],
        ]);

        // Clean phone number to digits only
        $cleanPhone = preg_replace('/\D/', '', $credentials['phone']);

        // Attempt login
        if (Auth::attempt(['phone' => $cleanPhone, 'password' => $credentials['password']])) {
            $user = Auth::user();
            // Only allow admin or superadmin
            if (in_array($user->role, ['admin', 'superadmin'], true)) {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            }
            // Not an admin: logout and show error
            Auth::logout();
            return back()->withErrors(['phone' => 'Faqat adminlar uchun kirish mumkin.'])->withInput($request->only('phone'));
        }

        // Invalid credentials
        return back()->withErrors([
            'phone' => 'Telefon raqami yoki parol noto‘g‘ri.',
        ])->withInput($request->only('phone'));
    }
} 