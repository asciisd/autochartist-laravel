# Autochartist for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/asciisd/autochartist-laravel.svg)](https://packagist.org/packages/asciisd/autochartist-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/asciisd/autochartist-laravel.svg)](https://packagist.org/packages/asciisd/autochartist-laravel)
[![License](https://img.shields.io/packagist/l/asciisd/autochartist-laravel.svg)](https://packagist.org/packages/asciisd/autochartist-laravel)

A lightweight Laravel integration for the [Autochartist](https://www.autochartist.com/) API. It handles request authentication for you and exposes a simple, fluent way to fetch technical analysis data.

## Requirements

- PHP `^8.1`
- Laravel 10, 11, 12, or 13

## Installation

Install the package via Composer:

```bash
composer require asciisd/autochartist-laravel
```

The service provider and the `Autochartist` facade are registered automatically through Laravel package discovery.

## Publishing the Config File

Publish the configuration file to your application's `config` directory:

```bash
php artisan vendor:publish --tag=autochartist-config
```

This creates `config/autochartist.php`, where all values are read from your environment.

## Environment Variables

Add the following keys to your Laravel project's `.env` file:

```dotenv
AUTOCHARTIST_URL=https://api.autochartist.com/
AUTOCHARTIST_BROKER_ID=your-broker-id
AUTOCHARTIST_SECRET_KEY=your-secret-key
AUTOCHARTIST_ACCOUNT_TYPE=demo
AUTOCHARTIST_TOKEN_TTL=259200
```

| Variable | Required | Description |
| --- | --- | --- |
| `AUTOCHARTIST_URL` | No | Base URL for all API requests. Defaults to `https://api.autochartist.com/`. |
| `AUTOCHARTIST_BROKER_ID` | Yes | Your customer (broker) ID on Autochartist's systems. |
| `AUTOCHARTIST_SECRET_KEY` | Yes | The secret used to sign the request token. Keep this private. |
| `AUTOCHARTIST_ACCOUNT_TYPE` | No | `demo` or `live`. Defaults to `demo`. |
| `AUTOCHARTIST_TOKEN_TTL` | No | How long (in seconds) a generated token stays valid. Defaults to `259200` (3 days). |

## Usage

### Fetching Technical Trade Setups

Use the `Autochartist` facade to reach the Technical Analysis service and call `technicalTradeSetups()`. It returns the API response decoded into a PHP array (JSON data):

```php
use Asciisd\AutochartistLaravel\Facades\Autochartist;

$setups = Autochartist::technicalAnalysis()->technicalTradeSetups();

return response()->json($setups);
```

You can pass a query array to filter the results:

```php
use Asciisd\AutochartistLaravel\Facades\Autochartist;

$setups = Autochartist::technicalAnalysis()->technicalTradeSetups([
    'group' => 'Currencies',
]);
```

You may also resolve the service from the container instead of using the facade:

```php
use Asciisd\AutochartistLaravel\Services\AutochartistManager;

$setups = app(AutochartistManager::class)
    ->technicalAnalysis()
    ->technicalTradeSetups();
```

### Authentication Requirement

Autochartist credentials are generated per authenticated user (the request token is bound to the user's email). Calls must therefore run within an authenticated context, for example inside a route protected by the `auth` middleware:

```php
use Asciisd\AutochartistLaravel\Facades\Autochartist;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/trade-setups', function () {
    return Autochartist::technicalAnalysis()->technicalTradeSetups();
});
```

If no user is authenticated, or if the secret key is missing, an `Asciisd\AutochartistLaravel\Exceptions\AutochartistException` is thrown.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
