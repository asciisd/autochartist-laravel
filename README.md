# Autochartist Laravel SDK

[![Latest Version](https://img.shields.io/packagist/v/asciisd/autochartist.svg?style=flat-square)](https://packagist.org/packages/asciisd/autochartist)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/asciisd/autochartist.svg?style=flat-square)](https://packagist.org/packages/asciisd/autochartist)

A Laravel package for integrating with the Autochartist API. This SDK provides a clean, expressive interface for accessing market snapshots, technical analysis, and news sentiment data.

## About Autochartist

Autochartist is a powerful technical analysis tool that automatically identifies chart patterns, Fibonacci levels, and key support/resistance levels across multiple financial markets. This SDK enables seamless integration with Laravel applications for forex, stocks, and cryptocurrency trading platforms.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Market Snapshot Service](#market-snapshot-service)
  - [Technical Analysis Service](#technical-analysis-service)
  - [News Sentiment Service](#news-sentiment-service)
- [Error Handling](#error-handling)
- [API Reference](#api-reference)
- [Troubleshooting](#troubleshooting)
- [Testing](#testing)
- [Support](#support)
- [License](#license)

## Features

- **Market Snapshot Service** - Access pre-market analysis generated 3x daily before major trading sessions (Tokyo, London, New York)
- **Technical Analysis Service** - Get chart patterns, key levels, Fibonacci retracements, and trading setups
- **News Sentiment Service** - Analyze market sentiment from news sources with historical data and alerts
- Automatic authentication token generation and management
- Type-safe DTOs for all API requests
- Laravel Facade support for clean syntax
- Comprehensive error handling with descriptive exceptions
- PSR-4 autoloading

## Requirements

- PHP 8.2 or higher
- Laravel 12.0 or higher
- Valid Autochartist API credentials

## Quick Start

```bash
# Install package
composer require asciisd/autochartist

# Publish configuration
php artisan vendor:publish --provider="Asciisd\Autochartist\AutochartistServiceProvider"

# Add credentials to .env
AUTOCHARTIST_USER=your-user-id
AUTOCHARTIST_BROKER_ID=your-broker-id
AUTOCHARTIST_SECRET_KEY=your-secret-key
```

**First API Call:**

```php
use Asciisd\Autochartist\Facades\Autochartist;

// Get latest market snapshots
$snapshots = Autochartist::marketSnapshot()->getSnapshotTypes();

// Get trading setups for EUR/USD
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;

$setups = Autochartist::technicalAnalysis()->getTradeSetups(
    new TradeSetupsRequest(symbols: ['EURUSD'])
);
```

## Installation

Install the package via Composer:

```bash
composer require asciisd/autochartist
```

The service provider will be automatically registered.

### Publish Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Asciisd\Autochartist\AutochartistServiceProvider"
```

This will create a `config/autochartist.php` file in your application.

## Configuration

Add your Autochartist credentials to your `.env` file:

```env
AUTOCHARTIST_BASE_URL=https://api.autochartist.com
AUTOCHARTIST_USER=your-user-id
AUTOCHARTIST_BROKER_ID=your-broker-id
AUTOCHARTIST_ACCOUNT_TYPE=0
AUTOCHARTIST_EXPIRY=1735689600
AUTOCHARTIST_SECRET_KEY=your-secret-key
AUTOCHARTIST_TIMEZONE=UTC
AUTOCHARTIST_LOCALE=en
```

### Configuration Parameters

- `base_url` - Autochartist API base URL
- `user` - Your Autochartist user ID
- `broker_id` - Your broker ID
- `account_type` - Account type (0 = LIVE, 1 = DEMO)
- `expiry` - Token expiry as Unix timestamp
- `secret_key` - Your secret key for token generation (keep secure!)
- `timezone` - Default timezone for API requests (default: UTC)
- `locale` - Default locale for API responses (default: en)

## Usage

### Using the Facade

```php
use Asciisd\Autochartist\Facades\Autochartist;

// Market Snapshot
$snapshots = Autochartist::marketSnapshot()->getSnapshotTypes();

// Technical Analysis
$setups = Autochartist::technicalAnalysis()->getTradeSetups();

// News Sentiment
$sentiment = Autochartist::newsSentiment()->getSentiment();
```

### Dependency Injection

```php
use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;
use Asciisd\Autochartist\Services\NewsSentimentService;

class TradingController extends Controller
{
    public function __construct(
        private MarketSnapshotService $marketSnapshot,
        private TechnicalAnalysisService $technicalAnalysis,
        private NewsSentimentService $newsSentiment
    ) {}

    public function index()
    {
        $snapshots = $this->marketSnapshot->getSnapshotTypes();
        // ...
    }
}
```

## Market Snapshot Service

Market snapshots are generated 3 times daily before major trading sessions.

### Get Available Snapshot Types

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest;
use Asciisd\Autochartist\Facades\Autochartist;

// Get all available snapshot types
$types = Autochartist::marketSnapshot()->getSnapshotTypes();

// With custom request
$request = new SnapshotTypesRequest();
$types = Autochartist::marketSnapshot()->getSnapshotTypes($request);
```

**Example Response:**

```json
{
  "data": [
    {
      "id": "market-snapshot",
      "name": "Market Snapshot",
      "description": "Pre-market analysis"
    }
  ]
}
```

### Get Snapshot Instances

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotInstancesRequest;

$request = new SnapshotInstancesRequest(
    reportId: 'market-snapshot',
    limit: 10
);

$instances = Autochartist::marketSnapshot()->getSnapshotInstances($request);
```

### Get Specific Snapshot

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotRequest;

$request = new SnapshotRequest(
    reportId: 'market-snapshot',
    reportUid: 'latest', // or specific UID
    include: ['symbol_reports', 'messages'],
    locale: 'en'
);

$snapshot = Autochartist::marketSnapshot()->getSnapshot($request);
```

### Get Pattern Details

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\PatternDetailRequest;

$request = new PatternDetailRequest(
    type: 'fibonacci',
    uid: 'pattern-uuid'
);

$details = Autochartist::marketSnapshot()->getPatternDetail($request);
```

### Send Email Snapshot

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\EmailSnapshotRequest;

$request = new EmailSnapshotRequest(
    reportId: 'market-snapshot',
    reportUid: 'latest',
    email: 'trader@example.com'
);

$result = Autochartist::marketSnapshot()->emailSnapshot($request);
```

### Get Chart Image URL

```php
use Asciisd\Autochartist\DTOs\MarketSnapshot\ChartImageRequest;

$request = new ChartImageRequest(
    type: 'chartpattern',
    uid: 'pattern-uuid',
    width: 800,
    height: 600
);

$imageUrl = Autochartist::marketSnapshot()->getChartImageUrl($request);
```

## Technical Analysis Service

Access chart patterns, key levels, and Fibonacci retracements.

### Get Trade Setups

```php
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;

$request = new TradeSetupsRequest(
    symbols: ['EURUSD', 'GBPUSD'],
    types: ['chartpattern', 'keylevels'],
    status: 'emerging',
    limit: 50
);

$setups = Autochartist::technicalAnalysis()->getTradeSetups($request);
```

**Example Response:**

```json
{
  "data": [
    {
      "uid": "abc123",
      "symbol": "EURUSD",
      "type": "chartpattern",
      "pattern": "Triangle",
      "status": "emerging",
      "quality": 8,
      "direction": "bullish",
      "interval": "H4",
      "probability": {
        "direction": 0.75
      }
    }
  ],
  "meta": {
    "total": 42,
    "limit": 50
  }
}
```

### Get Pattern Details

```php
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\PatternDetailRequest;

$request = new PatternDetailRequest(
    type: 'chartpattern',
    uid: 'pattern-uuid'
);

$details = Autochartist::technicalAnalysis()->getPatternDetail($request);
```

### Get Drawing Data

```php
$request = new PatternDetailRequest(
    type: 'fibonacci',
    uid: 'pattern-uuid'
);

$drawingData = Autochartist::technicalAnalysis()->getDrawingData($request);
```

### Get Chart Image URL

```php
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\ChartImageRequest;

$request = new ChartImageRequest(
    type: 'keylevels',
    uid: 'pattern-uuid',
    width: 1024,
    height: 768,
    format: 'png'
);

$imageUrl = Autochartist::technicalAnalysis()->getChartImageUrl($request);
```

## News Sentiment Service

Analyze market sentiment from news sources.

### Get Latest Sentiment

```php
use Asciisd\Autochartist\DTOs\NewsSentiment\SentimentRequest;

$request = new SentimentRequest(
    symbols: ['AAPL', 'GOOGL'],
    sectors: ['technology'],
    limit: 20
);

$sentiment = Autochartist::newsSentiment()->getSentiment($request);
```

**Example Response:**

```json
{
  "data": [
    {
      "ticker": "AAPL",
      "score": 45.2,
      "trend": "positive",
      "articles_count": 127,
      "last_updated": "2026-05-04T10:30:00Z",
      "top_sources": ["Reuters", "Bloomberg"]
    }
  ]
}
```

### Get Extreme Score Changes

Get sentiments where the score changed by 30+ points:

```php
use Asciisd\Autochartist\DTOs\NewsSentiment\ExtremeScoreChangeRequest;

$request = new ExtremeScoreChangeRequest(
    symbols: ['EURUSD'],
    limit: 10
);

$extremeChanges = Autochartist::newsSentiment()->getExtremeScoreChange($request);
```

### Get Significant Sentiments

Get sentiments that reached very positive (>60) or very negative (<-60):

```php
use Asciisd\Autochartist\DTOs\NewsSentiment\SignificantSentimentRequest;

$request = new SignificantSentimentRequest(
    symbols: ['BTCUSD'],
    limit: 10
);

$significant = Autochartist::newsSentiment()->getSignificantSentiment($request);
```

### Get Historical Sentiment

```php
use Asciisd\Autochartist\DTOs\NewsSentiment\HistoryRequest;

$request = new HistoryRequest(
    ticker: 'AAPL',
    startDate: '2026-01-01',
    endDate: '2026-04-14'
);

$history = Autochartist::newsSentiment()->getHistory($request);
```

### Get Available Sectors

```php
$sectors = Autochartist::newsSentiment()->getSectors();
```

### Get News Sources

```php
$sources = Autochartist::newsSentiment()->getSources();
```

## Error Handling

All API errors throw `AutochartistException`:

```php
use Asciisd\Autochartist\Exceptions\AutochartistException;

try {
    $snapshots = Autochartist::marketSnapshot()->getSnapshotTypes();
} catch (AutochartistException $e) {
    Log::error('Autochartist API error: ' . $e->getMessage());
    // Handle error
}
```

## API Reference

### Available Pattern Types

- `chartpattern` - Triangle, Head & Shoulders, Double Top/Bottom, etc.
- `fibonacci` - Fibonacci retracements and extensions
- `keylevels` - Support and resistance levels

### Pattern Status Values

- `emerging` - Pattern is forming but not completed
- `completed` - Pattern has completed
- `approaching` - Price is approaching a key level

### Account Types

- `0` - LIVE account
- `1` - DEMO account

### Supported Locales

`en`, `es`, `fr`, `de`, `it`, `pt`, `ru`, `zh`, `ja`, `ar`

### Common Response Structure

Most endpoints return data in this format:

```json
{
  "data": [...],
  "meta": {
    "total": 100,
    "limit": 20,
    "offset": 0
  }
}
```

## Troubleshooting

### Authentication Errors (401)

**Problem:** `Authentication failed` or `Invalid token`

**Solutions:**

1. Verify credentials in `.env` file are correct
2. Check expiry timestamp is in the future (Unix timestamp)
3. Ensure secret key matches your Autochartist account
4. Confirm broker ID is correctly configured

```bash
# Regenerate token by clearing cache
php artisan config:clear
```

### Rate Limiting (429)

**Problem:** `Too many requests`

**Solutions:**

- Autochartist has rate limits - implement exponential backoff
- Cache frequently accessed data
- Use batch requests when available

```php
// Example: Cache snapshot types for 1 hour
$types = Cache::remember('autochartist.snapshot.types', 3600, function () {
    return Autochartist::marketSnapshot()->getSnapshotTypes();
});
```

### Empty Results

**Problem:** API returns empty arrays

**Solutions:**

1. Check if symbols are correctly formatted (e.g., `EURUSD` not `EUR/USD`)
2. Verify your account has access to requested data
3. Confirm date ranges are valid
4. Check if patterns exist for the requested criteria

### Connection Timeouts

**Problem:** Requests timing out

**Solutions:**

- Check network connectivity
- Verify `AUTOCHARTIST_BASE_URL` is correct
- Increase timeout in HTTP client (if customized)

### Missing Configuration

**Problem:** `Configuration file not found`

**Solution:**

```bash
php artisan vendor:publish --provider="Asciisd\Autochartist\AutochartistServiceProvider" --force
```

## Best Practices

### 1. Cache Results

```php
// Cache expensive API calls
$sentiment = Cache::remember(
    "sentiment.{$symbol}",
    now()->addMinutes(15),
    fn() => Autochartist::newsSentiment()->getSentiment(
        new SentimentRequest(symbols: [$symbol])
    )
);
```

### 2. Use Queued Jobs for Bulk Operations

```php
// Process multiple symbols asynchronously
foreach ($symbols as $symbol) {
    ProcessTechnicalAnalysis::dispatch($symbol);
}
```

### 3. Validate Symbols Before API Calls

```php
$validSymbols = ['EURUSD', 'GBPUSD', 'USDJPY'];
$symbols = array_intersect($requestedSymbols, $validSymbols);
```

### 4. Handle Exceptions Gracefully

```php
try {
    return Autochartist::technicalAnalysis()->getTradeSetups($request);
} catch (AutochartistException $e) {
    report($e);
    return collect([]); // Return empty collection as fallback
}
```

## Testing

This package comes with comprehensive test coverage including 39 tests with 72 assertions covering all services and features.

### Running Tests

Run all tests:

```bash
composer test
```

Run specific test suite:

```bash
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Feature
```

Run specific test file:

```bash
vendor/bin/phpunit tests/Unit/AuthenticationServiceTest.php
```

Run specific test method:

```bash
vendor/bin/phpunit --filter test_authentication_service_generates_token
```

Run tests with coverage:

```bash
composer test:coverage
```

The coverage report will be generated in the `coverage/` directory.

### Test Coverage

The test suite covers:

**Unit Tests (24 tests):**

- ✅ Authentication token generation and validation (4 tests)
- ✅ Manager service instantiation (4 tests)
- ✅ Market Snapshot API methods (6 tests)
- ✅ Technical Analysis API methods (5 tests)
- ✅ News Sentiment API methods (7 tests)

**Feature Tests (15 tests):**

- ✅ Laravel Facade integration (3 tests)
- ✅ Service Provider registration (4 tests)
- ✅ Error handling and exceptions (3 tests)
- ✅ End-to-end workflow integration (3 tests)

### Test Structure

```
tests/
├── TestCase.php              # Base test case with Orchestra Testbench
├── Unit/                     # Unit tests (24 tests)
│   ├── AuthenticationServiceTest.php
│   ├── AutochartistManagerTest.php
│   └── Services/
│       ├── MarketSnapshotServiceTest.php
│       ├── TechnicalAnalysisServiceTest.php
│       └── NewsSentimentServiceTest.php
└── Feature/                  # Integration tests (15 tests)
    ├── AutochartistFacadeTest.php
    ├── ServiceProviderTest.php
    ├── ErrorHandlingTest.php
    └── IntegrationTest.php
```

### Writing Tests

All tests use HTTP mocking to avoid requiring real API credentials:

```php
use Illuminate\Support\Facades\Http;
use Asciisd\Autochartist\Tests\TestCase;

class MyTest extends TestCase
{
    public function test_example(): void
    {
        // Mock HTTP response
        Http::fake([
            '*' => Http::response(['data' => 'test'], 200),
        ]);

        // Test your code
        $result = Autochartist::marketSnapshot()->getSnapshotTypes();

        $this->assertArrayHasKey('data', $result);
    }
}
```

### CI/CD Integration

The package includes a GitHub Actions workflow (`.github/workflows/tests.yml`) that runs tests on:

- PHP 8.2 and 8.3
- Laravel 12 and 13
- Multiple dependency versions (lowest, stable)

Tests run automatically on push to `main` and `develop` branches and on all pull requests.

For more detailed testing documentation, see [tests/README.md](tests/README.md).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email security@asciisd.com instead of using the issue tracker.

## Credits

- [Autochartist](https://www.autochartist.com/) - API provider
- [ASCIISD](https://asciisd.com) - Package maintainer
- [All Contributors](../../contributors)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For help and support:

- 📚 [Autochartist API Documentation](https://support.autochartist.com/)
- 🔐 [Security Token Generation Guide](https://support.autochartist.com/en/knowledgebase/article/security-token-generation)
- 🐛 [Issue Tracker](https://github.com/asciisd/autochartist/issues)
- 📧 Email: support@asciisd.com

---

Made with ❤️ by [ASCIISD](https://asciisd.com)
