<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OneIdController extends Controller
{
    public function redirectToOneId()
    {
        return Socialite::driver('oneid')
            ->with(['client_id' => 'ubtuit_uz'])
            ->redirect();
    }

    public function handleOneIdCallback(Request $request)
    {
        try {
            // EGOV ID callback parameters
            $clientId = $request->get('client_id');
            $tokenId = $request->get('token_id');
            $method = $request->get('method');

            if (!$tokenId) {
                throw new \Exception('Token ID topilmadi');
            }

            // EGOV ID user ma'lumotlarini olish
            $response = $this->getHttpClient()->get("https://id.egov.uz/api/user/info", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenId,
                    'Client-ID' => $clientId,
                ],
            ]);

            $userData = json_decode($response->getBody(), true);

            // Foydalanuvchini yaratish yoki yangilash
            $fullName = explode(' ', $userData['full_name'] ?? $userData['name'] ?? '');
            $user = User::updateOrCreate([
                'oneid_id' => $userData['user_id'] ?? $userData['id'] ?? $tokenId,
            ], [
                'oneid_token' => $tokenId,
                'password' => bcrypt(str()->random(16)),
                'last_name' => $fullName[0] ?? '',
                'first_name' => $fullName[1] ?? '',
                'middle_name' => $fullName[2] ?? '',
                'phone' => isset($userData['phone']) ? preg_replace('/\D/', '', $userData['phone']) : '',
            ]);

            Auth::login($user);

            return redirect()->intended('/my-applications');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'EGOV ID bilan kirishda xatolik: ' . $e->getMessage()]);
        }
    }

    private function getHttpClient()
    {
        return new \GuzzleHttp\Client();
    }
}
