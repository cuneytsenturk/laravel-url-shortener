<?php

use Illuminate\Container\Container;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public static $functions;

    public function setUp(): void
    {
        parent::setUp();

        self::$functions = m::mock();

        Container::setInstance(new Container());

        $store = m::mock('CuneytSenturk\UrlShortener\Contracts\Driver');

        app()->bind('url_shortener', function () use ($store) {
            return $store;
        });
    }

    /** @test */
    public function helper_without_parameters_returns_store()
    {
        $this->assertInstanceOf('CuneytSenturk\UrlShortener\Contracts\Driver', url_shortener());
    }

    /** @test */
    public function single_parameter_get_a_key_from_store()
    {
        app('url_shortener')->shouldReceive('get')->with('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', null)->once();

        url_shortener('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter');
    }

    public function two_parameters_return_a_default_value()
    {
        app('url_shortener')->shouldReceive('get')->with('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123')->once();

        url_shortener('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123');
    }

    /** @test */
    public function array_parameter_call_set_method_into_store()
    {
        app('url_shortener')->shouldReceive('set')->with(['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123'])->once();

        url_shortener(['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123']);
    }
}
