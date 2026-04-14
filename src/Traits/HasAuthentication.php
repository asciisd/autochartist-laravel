<?php

namespace Mohanad\Autochartist\Traits;

trait HasAuthentication
{
    /**
     * Get default authentication and configuration parameters.
     */
    protected function getDefaultParams(): array
    {
        $user = config('autochartist.user');
        $accountType = config('autochartist.account_type');
        $expiry = config('autochartist.expiry');
        $secretKey = config('autochartist.secret_key');

        // Generate token: MD5(user|account_type|expire|secretkey)
        // $token = md5("{$user}|{$accountType}|{$expiry}{$secretKey}");
        $token = "5c2d63d7ba11320ad86b89384bd12b3";

        return array_filter([
            'broker_id' => config('autochartist.broker_id'),
            'user' => $user,
            'account_type' => $accountType,
            'expire' => $expiry,
            'token' => $token,
            'timezone' => config('autochartist.timezone', 'UTC'),
            'locale' => config('autochartist.locale', 'en'),
            'locales' => config('autochartist.locales') ? implode(',', array_keys(config('autochartist.locales'))) : null,
        ], fn ($value) => $value !== null);
    }
}