<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autochartist API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL all API requests are made against. A trailing slash is
    | optional; it is normalised before each request.
    |
    */
    'url' => env('AUTOCHARTIST_URL', 'https://api.autochartist.com/'),

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | "broker_id" is your customer ID on Autochartist's systems and
    | "secret_key" is the secret used to sign the request token. Neither
    | should be exposed to end users.
    |
    */
    'broker_id' => env('AUTOCHARTIST_BROKER_ID'),
    'secret_key' => env('AUTOCHARTIST_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Account Type
    |--------------------------------------------------------------------------
    |
    | Autochartist expects 0 = LIVE, 1 = DEMO. You may use the friendly
    | strings "live"/"demo" here; they are normalised to the numeric value.
    |
    */
    'account_type' => env('AUTOCHARTIST_ACCOUNT_TYPE', 'demo'),

    /*
    |--------------------------------------------------------------------------
    | Token Time-To-Live
    |--------------------------------------------------------------------------
    |
    | How long (in seconds) a generated token remains valid. Defaults to
    | three days, matching Autochartist's reference implementation.
    |
    */
    'token_ttl' => (int) env('AUTOCHARTIST_TOKEN_TTL', 3 * 24 * 60 * 60),

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | The styles to use for light and dark mode. Default is "light".
    | Available options are: "light", "dark".
    |
    */
    'style' => env('AUTOCHARTIST_STYLE', 'light'),

];
