<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Arr;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class OneIdController extends Controller
{
    public function redirectToOneId()
    {
        $driver = Socialite::driver('oneid');
        $scopes = collect(explode(' ', (string) config('services.oneid.scope')))
            ->filter()
            ->values()
            ->all();

        if ($scopes !== []) {
            $driver->scopes($scopes);
        }

        return $driver->redirect();
    }

    public function handleOneIdCallback(Request $request)
    {
        try {
            $driver = Socialite::driver('oneid');
            $scopes = collect(explode(' ', (string) config('services.oneid.scope')))
                ->filter()
                ->values()
                ->all();

            if ($scopes !== []) {
                $driver->scopes($scopes);
            }

            $oauthUser = $driver->user();
            $rawUser = is_array($oauthUser->user ?? null) ? $oauthUser->user : [];
            $oneId = (string) ($oauthUser->getId() ?? Arr::get($rawUser, 'user_id'));

            if ($oneId === '') {
                throw new \RuntimeException(__('messages.oneid_no_id'));
            }

            $phone = $this->resolvePhone($rawUser, $oneId);

            $user = User::query()
                ->where('oneid_id', $oneId)
                ->orWhere('phone', $phone)
                ->first();

            if ($user) {
                $user->forceFill(array_filter([
                    'oneid_id' => $oneId,
                    'oneid_token' => $oauthUser->token,
                    'phone' => $user->phone ?: $phone,
                    'first_name' => $user->first_name ?: Arr::get($rawUser, 'first_name', ''),
                    'last_name' => $user->last_name ?: Arr::get($rawUser, 'last_name', Arr::get($rawUser, 'sur_name', '')),
                    'middle_name' => $user->middle_name ?: Arr::get($rawUser, 'middle_name', Arr::get($rawUser, 'mid_name', '')),
                ], fn ($v) => $v !== ''))->save();
            } else {
                $user = User::create([
                    'oneid_id' => $oneId,
                    'oneid_token' => $oauthUser->token,
                    'phone' => $phone,
                    'first_name' => Arr::get($rawUser, 'first_name', ''),
                    'last_name' => Arr::get($rawUser, 'last_name', Arr::get($rawUser, 'sur_name', '')),
                    'middle_name' => Arr::get($rawUser, 'middle_name', Arr::get($rawUser, 'mid_name', '')),
                    'role' => 'user',
                    'password' => bcrypt(str()->random(32)),
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect()->route('my.applications');
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('login')->withErrors([
                'oneid' => __('messages.oneid_error'),
            ]);
        }
    }

    private function resolvePhone(array $rawUser, string $oneId): string
    {
        $candidate = Arr::first([
            Arr::get($rawUser, 'phone'),
            Arr::get($rawUser, 'phone_number'),
            Arr::get($rawUser, 'mob_phone_no'),
            Arr::get($rawUser, 'mobile'),
        ], fn (?string $value) => filled($value));

        $normalized = User::normalizePhone(is_string($candidate) ? $candidate : null);

        return $normalized ?? 'oneid-'.$oneId;
    }
}
