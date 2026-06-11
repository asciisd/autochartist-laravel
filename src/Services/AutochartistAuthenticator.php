<?php

namespace Asciisd\AutochartistLaravel\Services;

use Asciisd\AutochartistLaravel\Exceptions\AutochartistException;

class AutochartistAuthenticator
{
    /**
     * Build the authentication parameters Autochartist requires on every call.
     *
     * The token is hashed with the numeric account type (0 = LIVE, 1 = DEMO),
     * while the URL itself carries the human readable label (LIVE/DEMO).
     *
     * @return array{broker_id: mixed, user: string, account_type: string, expire: int, token: string}
     */
    public function credentials(): array
    {
        if (! auth()->check()) {
            throw AutochartistException::userNotAuthenticated();
        }

        $user = (string) auth()->user()->email;
        $accountType = $this->resolveAccountType();
        $expire = time() + (int) config('autochartist.token_ttl', 3 * 24 * 60 * 60);

        return [
            'broker_id' => config('autochartist.broker_id'),
            'user' => $user,
            'account_type' => $this->accountTypeLabel($accountType),
            'expire' => $expire,
            'token' => $this->generateToken($user, $accountType, $expire),
        ];
    }

    /**
     * Generate the request token: MD5(user|accounttype|expire{secretkey}).
     */
    public function generateToken(string $user, int $accountType, int $expire): string
    {
        $secretKey = config('autochartist.secret_key');

        if (empty($secretKey)) {
            throw AutochartistException::missingSecretKey();
        }

        return md5("{$user}|{$accountType}|{$expire}{$secretKey}");
    }

    /**
     * Autochartist expects: 0 = LIVE, 1 = DEMO.
     */
    private function resolveAccountType(): int
    {
        $type = strtolower((string) config('autochartist.account_type'));

        return in_array($type, ['live', '0'], true) ? 0 : 1;
    }

    /**
     * The URL-facing account type label expected by Autochartist (LIVE/DEMO).
     */
    private function accountTypeLabel(int $accountType): string
    {
        return $accountType === 0 ? 'LIVE' : 'DEMO';
    }
}
