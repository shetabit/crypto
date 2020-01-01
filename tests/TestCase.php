<?php

namespace Shetabit\Crypto\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Shetabit\Crypto\Tests\Mocks\Drivers\BarDriver;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Shetabit\Crypto\Provider\CryptoServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Crypto' => 'Shetabit\Crypto\Facade\Crypto',
        ];
    }
}
