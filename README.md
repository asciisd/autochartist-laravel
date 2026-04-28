# Autochartist Laravel SDK

A Laravel package for integrating with the Autochartist API. This SDK provides a clean, expressive interface for accessing market snapshots, technical analysis, and news sentiment data.

## Features

- **Market Snapshot Service** - Access pre-market analysis generated 3x daily before major trading sessions (Tokyo, London, New York)
- **Technical Analysis Service** - Get chart patterns, key levels, Fibonacci retracements, and trading setups
- **News Sentiment Service** - Analyze market sentiment from news sources with historical data and alerts
- Automatic authentication token generation
- Type-safe DTOs for all API requests
- Laravel Facade support
- Comprehensive error handling

## Requirements

- PHP 8.2 or higher
- Laravel 12.0 or higher

## Installation

Install the package via Composer:

```bash
composer require mohanad/autochartist
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

## Testing

```bash
composer test
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For API documentation and support, visit:

- [Autochartist API Documentation](https://support.autochartist.com/)
- [Security Token Generation](https://support.autochartist.com/en/knowledgebase/article/security-token-generation)

## Credits

- [Mohanad](https://github.com/mohanad)
- [All Contributors](../../contributors)

# autochartist-laravel
