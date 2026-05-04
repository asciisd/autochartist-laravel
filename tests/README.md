# Autochartist Package Tests

This directory contains comprehensive tests for the Autochartist Laravel SDK package.

## Test Structure

```
tests/
├── TestCase.php              # Base test case for all tests
├── Unit/                     # Unit tests
│   ├── AuthenticationServiceTest.php
│   ├── AutochartistManagerTest.php
│   └── Services/
│       ├── MarketSnapshotServiceTest.php
│       ├── TechnicalAnalysisServiceTest.php
│       └── NewsSentimentServiceTest.php
└── Feature/                  # Feature/Integration tests
    ├── AutochartistFacadeTest.php
    ├── ServiceProviderTest.php
    ├── ErrorHandlingTest.php
    └── IntegrationTest.php
```

## Running Tests

### Run all tests

```bash
composer test
```

or

```bash
vendor/bin/phpunit
```

### Run specific test suite

```bash
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Feature
```

### Run specific test file

```bash
vendor/bin/phpunit tests/Unit/AuthenticationServiceTest.php
```

### Run with coverage report

```bash
composer test:coverage
```

The coverage report will be generated in the `coverage/` directory.

### Run specific test method

```bash
vendor/bin/phpunit --filter test_get_auth_params_includes_all_required_fields
```

## Test Categories

### Unit Tests

Unit tests focus on testing individual components in isolation:

- **AuthenticationServiceTest**: Tests token generation and auth parameter building
- **AutochartistManagerTest**: Tests the main manager class that provides access to services
- **MarketSnapshotServiceTest**: Tests market snapshot service methods
- **TechnicalAnalysisServiceTest**: Tests technical analysis service methods
- **NewsSentimentServiceTest**: Tests news sentiment service methods

### Feature Tests

Feature tests verify the integration of components:

- **AutochartistFacadeTest**: Tests the Laravel facade functionality
- **ServiceProviderTest**: Tests service provider registration and configuration
- **ErrorHandlingTest**: Tests error handling and exception throwing
- **IntegrationTest**: Tests complete workflows across multiple services

## Writing New Tests

All tests should extend the base `TestCase` class:

```php
<?php

namespace Asciisd\Autochartist\Tests\Unit;

use Asciisd\Autochartist\Tests\TestCase;

class MyNewTest extends TestCase
{
    public function test_something(): void
    {
        // Your test code here
        $this->assertTrue(true);
    }
}
```

### Mocking HTTP Responses

Use Laravel's HTTP facade to mock API responses:

```php
use Illuminate\Support\Facades\Http;

Http::fake([
    '*' => Http::response(['data' => 'test'], 200),
]);

$result = $service->someMethod();
```

## Configuration

Test configuration is defined in:

- `phpunit.xml` - PHPUnit configuration
- `TestCase.php` - Base test case with default config values

Default test configuration:

- Base URL: `https://api.autochartist.com`
- User: `test_user`
- Broker ID: `test_broker`
- Account Type: `demo`
- Expiry: `2099-12-31`
- Secret Key: `test_secret_key`

## CI/CD Integration

These tests are designed to run in CI/CD pipelines. Make sure to:

1. Install dependencies: `composer install`
2. Run tests: `composer test`
3. Check coverage: `composer test:coverage`

## Troubleshooting

### Tests failing with "Class not found"

Make sure you've run `composer install` to install dependencies.

### HTTP mocking not working

Ensure you're using `Illuminate\Support\Facades\Http` facade in your tests.

### Configuration not loading

Check that `defineEnvironment()` is properly set in the base `TestCase.php`.
