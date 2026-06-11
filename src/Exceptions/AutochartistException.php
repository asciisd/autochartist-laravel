<?php

namespace Asciisd\AutochartistLaravel\Exceptions;

use Exception;

class AutochartistException extends Exception
{
    public static function userNotAuthenticated(): self
    {
        return new self('Autochartist requires an authenticated user to generate API credentials.');
    }

    public static function missingSecretKey(): self
    {
        return new self('Autochartist secret key is not configured. Set AUTOCHARTIST_SECRET_KEY in your environment.');
    }

    public static function requestFailed(int $status, string $body): self
    {
        return new self("Autochartist request failed with status [{$status}]: {$body}");
    }
}
