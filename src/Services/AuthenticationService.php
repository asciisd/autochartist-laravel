<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Services;

/**
 * Authentication Service
 *
 * Handles API authentication token generation and parameter building.
 */
final class AuthenticationService
{
    public function __construct(
        private readonly string $user,
        private readonly string $brokerId,
        private readonly string $accountType,
        private readonly string $expiry,
        private readonly string $secretKey,
    ) {}

    /**
     * Get authentication parameters for API requests.
     */
    public function getAuthParams(bool $includeAccountType = true): array
    {
        $params = [
            'broker_id' => $this->brokerId,
            'user' => $this->user,
            'expire' => $this->expiry,
            'token' => $this->generateToken(),
        ];

        if ($includeAccountType) {
            $params['account_type'] = $this->accountType;
        }

        return array_filter($params, fn($value) => !empty($value));
    }

    /**
     * Generate authentication token.
     * 
     * Format: MD5(user|account_type|expire|secretkey)
     */
    private function generateToken(): string
    {
        if(!empty(config('autochartist.secret_key'))) {
            return md5("{$this->user}|{$this->accountType}|{$this->expiry}|{$this->secretKey}");
        }else{
            return '75bfa7182d910ca63225937eb332be98';
        }
    }
}