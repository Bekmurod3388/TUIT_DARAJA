<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;
use Illuminate\Http\Request;

class OneIdProvider extends AbstractProvider
{
    protected $scopeSeparator = ' ';

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://id.egov.uz/oauth/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return 'https://id.egov.uz/oauth/token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://id.egov.uz/oauth/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['user_id'] ?? $user['id'] ?? $user['token_id'],
            'name' => $user['full_name'] ?? $user['name'] ?? ($user['first_name'] . ' ' . ($user['last_name'] ?? '')),
            'email' => $user['email'],
            'avatar' => null,
        ]);
    }

    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
} 