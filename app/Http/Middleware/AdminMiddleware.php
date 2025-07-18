<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to restrict access to admin users only.
 * Redirects unauthenticated users to admin login, and blocks non-admins.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If not authenticated, redirect to admin login
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Only allow admin or superadmin roles
        if (!in_array($user->role, ['admin', 'superadmin'], true)) {
            abort(403, 'Sizda admin panelga kirish huquqi yo‘q.');
        }

        return $next($request);
    }
} 