<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OneIdController extends Controller
{
    public function redirectToOneId(Request $request)
    {
        $query = http_build_query([
            'response_type' => 'one_code',
            'client_id' => config('services.oneid.client_id'),
            'redirect_uri' => config('services.oneid.redirect'),
            'scope' => config('services.oneid.scope'),
            'state' => csrf_token(),
        ]);
        return redirect(config('services.oneid.auth_url') . '?' . $query);
    }

    public function handleOneIdCallback(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');

        // 1. Access token olish
        $tokenResponse = Http::asForm()->post(config('services.oneid.auth_url'), [
            'grant_type' => 'one_authorization_code',
            'client_id' => config('services.oneid.client_id'),
            'client_secret' => config('services.oneid.client_secret'),
            'code' => $code,
            'redirect_uri' => config('services.oneid.redirect'),
        ]);

        if (!$tokenResponse->ok() || !isset($tokenResponse['access_token'])) {
            return redirect()->route('login')->withErrors(['oneid' => 'OneID orqali avtorizatsiya muvaffaqiyatsiz tugadi.']);
            }

        $accessToken = $tokenResponse['access_token'];

        // 2. Foydalanuvchi ma’lumotlarini olish
        $userResponse = Http::asForm()->post(config('services.oneid.auth_url'), [
            'grant_type' => 'one_access_token_identify',
            'client_id' => config('services.oneid.client_id'),
            'client_secret' => config('services.oneid.client_secret'),
            'access_token' => $accessToken,
            'scope' => config('services.oneid.scope'),
            ]);

        if (!$userResponse->ok() || !isset($userResponse['pin'])) {
            return redirect()->route('login')->withErrors(['oneid' => 'OneID foydalanuvchi ma’lumotlarini olishda xatolik.']);
        }

        // 3. Foydalanuvchini topish yoki yaratish
        $user = User::where('oneid_id', $userResponse['user_id'])->orWhere('phone', $userResponse['pin'])->first();
        if (!$user) {
            $user = User::create([
                'oneid_id' => $userResponse['user_id'],
                'phone' => $userResponse['pin'],
                'first_name' => $userResponse['first_name'] ?? '',
                'last_name' => $userResponse['sur_name'] ?? '',
                'middle_name' => $userResponse['mid_name'] ?? '',
                'password' => bcrypt(str()->random(16)),
                'role' => 'user',
            ]);
        }

            Auth::login($user);

        return redirect()->route('my.applications');
    }
}
