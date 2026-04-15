<?php

namespace Mohanad\Autochartist\Traits;

trait HasAuthentication
{
    /**
     * Get authentication parameters only.
     */
    protected function getDefaultParams(?string $expiry = null): array
    {
        $user = config('autochartist.user');
        $accountType = config('autochartist.account_type');
        $secretKey = config('autochartist.secret_key');
        $expiry = $expiry ?? config('autochartist.expiry');

        // Generate token: MD5(user|account_type|expire|secretkey)
        $token = md5("{$user}|{$accountType}|{$expiry}|{$secretKey}");

        return array_filter([
            'broker_id' => config('autochartist.broker_id'),
            'user' => $user,
            'account_type' => $accountType,
            'expire' => $expiry,
            'token' => $token,
        ], fn ($value) => $value !== null);
    }
}