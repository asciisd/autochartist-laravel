<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Unit;

use Asciisd\Autochartist\Services\AuthenticationService;
use Asciisd\Autochartist\Tests\TestCase;

class AuthenticationServiceTest extends TestCase
{
    private AuthenticationService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = new AuthenticationService(
            user: 'test_user',
            brokerId: 'test_broker',
            accountType: 'demo',
            expiry: '2099-12-31',
            secretKey: 'test_secret_key'
        );
    }

    public function test_get_auth_params_includes_all_required_fields(): void
    {
        $params = $this->authService->getAuthParams();

        $this->assertArrayHasKey('broker_id', $params);
        $this->assertArrayHasKey('user', $params);
        $this->assertArrayHasKey('expire', $params);
        $this->assertArrayHasKey('token', $params);
        $this->assertArrayHasKey('account_type', $params);

        $this->assertEquals('test_broker', $params['broker_id']);
        $this->assertEquals('test_user', $params['user']);
        $this->assertEquals('2099-12-31', $params['expire']);
        $this->assertEquals('demo', $params['account_type']);
    }

    public function test_get_auth_params_excludes_account_type_when_requested(): void
    {
        $params = $this->authService->getAuthParams(includeAccountType: false);

        $this->assertArrayNotHasKey('account_type', $params);
        $this->assertArrayHasKey('broker_id', $params);
        $this->assertArrayHasKey('user', $params);
        $this->assertArrayHasKey('expire', $params);
        $this->assertArrayHasKey('token', $params);
    }

    public function test_token_is_generated_correctly(): void
    {
        $params = $this->authService->getAuthParams();
        
        // Expected token format: MD5(user|account_type|expire|secretkey)
        $expectedToken = md5('test_user|demo|2099-12-31|test_secret_key');

        $this->assertEquals($expectedToken, $params['token']);
    }

    public function test_auth_params_filters_empty_values(): void
    {
        $authService = new AuthenticationService(
            user: 'test_user',
            brokerId: '',
            accountType: 'demo',
            expiry: '2099-12-31',
            secretKey: 'test_secret_key'
        );

        $params = $authService->getAuthParams();

        $this->assertArrayNotHasKey('broker_id', $params);
        $this->assertArrayHasKey('user', $params);
    }
}
