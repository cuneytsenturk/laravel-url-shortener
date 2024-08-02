<?php

namespace CuneytSenturk\UrlShortener\Tests;

use CuneytSenturk\UrlShortener\Facade;
use CuneytSenturk\UrlShortener\Provider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

class TestCase extends TestBenchTestCase
{
    /**
     * Load the package service provider.
     */
    protected function getPackageProviders($app): array
    {
        return [
            Provider::class,
        ];
    }
}
