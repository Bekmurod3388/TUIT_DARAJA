<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'oneid' => [
        'client_id' => env('ONEID_CLIENT_ID'),
        'client_secret' => env('ONEID_CLIENT_SECRET'),
        'redirect' => env('ONEID_REDIRECT_URI'),
        'scope' => env('ONEID_SCOPE'),
        'auth_url' => env('ONEID_AUTH_URL'),
    ],

    'payme' => [
        'merchant_id' => env('PAYME_MERCHANT_ID'),
        'key' => env('PAYME_KEY'),
        'callback_url' => env('PAYME_CALLBACK_URL'),
    ],

];
