<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request, string $locale): RedirectResponse
    {
        if (in_array($locale, ['uz', 'ru', 'en'], true)) {
            $request->session()->put('locale', $locale);
        }

        $fallback = url('/login');
        $referer = $request->headers->get('referer');

        if (!is_string($referer) || $referer === '') {
            return redirect()->to($fallback);
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);
        $currentHost = $request->getHost();

        if ($refererHost !== null && $refererHost !== $currentHost) {
            return redirect()->to($fallback);
        }

        return redirect()->to($referer);
    }
}
