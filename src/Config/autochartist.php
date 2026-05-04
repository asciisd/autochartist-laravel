<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Autochartist API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Autochartist API endpoints.
    |
    */

    'base_url' => env('AUTOCHARTIST_BASE_URL', 'https://api.autochartist.com'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Credentials
    |--------------------------------------------------------------------------
    |
    | These credentials are used to authenticate with the Autochartist API.
    | See: https://support.autochartist.com/en/knowledgebase/article/security-token-generation
    |
    */

    'user' => env('AUTOCHARTIST_USER'),

    'broker_id' => env('AUTOCHARTIST_BROKER_ID'),

    'account_type' => env('AUTOCHARTIST_ACCOUNT_TYPE'), // 0 = LIVE, 1 = DEMO

    'expiry' => env('AUTOCHARTIST_EXPIRY'), // Unix timestamp

    'secret_key' => env('AUTOCHARTIST_SECRET_KEY'), // Secret key for token generation (DO NOT SHARE)

    'token' => env('AUTOCHARTIST_TOKEN'), // Optional pre-generated token (if not using secret key)
    

    /*
    |--------------------------------------------------------------------------
    | Localization Settings
    |--------------------------------------------------------------------------
    |
    | Default timezone and locale for API requests.
    |
    */

    'timezone' => env('AUTOCHARTIST_TIMEZONE', 'UTC'),

    'locale' => env('AUTOCHARTIST_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | List of supported locales for pattern descriptions.
    |
    */

    'locales' => [
        'en' => 'English',
        'tr' => 'Turkish',
        'ru' => 'Russian',
    ],

];