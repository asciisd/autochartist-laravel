<?php

namespace Asciisd\AutochartistLaravel\Exceptions;

use Exception;
use Throwable;

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

    public static function connectionFailed(string $message, ?Throwable $previous = null): self
    {
        return new self("Autochartist request could not be completed: {$message}", 0, $previous);
    }
}
