<?php

namespace  CuneytSenturk\UrlShortener\Tests\Feature;

use CuneytSenturk\UrlShortener\Tests\TestCase;
use CuneytSenturk\UrlShortener\Facade as UrlShortener;

class ShortLinkTest extends TestCase
{
    public function testEncodeUrl()
    {
        $originalUrl = 'https://github.com/cuneytsenturk/laravel-url-shortener';
        $shortenedUrl = 'https://short.url/encoded';

        $result_url = UrlShortener::encode($originalUrl, $shortenedUrl);

        $this->assertNotNull($result_url);
        $this->assertIsString($result_url);
        $this->assertNotEquals($originalUrl, $result_url);
    }

    public function testDecodeUrl()
    {
        $originalUrl = 'https://github.com/cuneytsenturk/laravel-url-shortener';
        $shortenedUrl = 'https://short.url/encoded';
        
        $shortenedUrl = UrlShortener::encode($originalUrl, $shortenedUrl);
        $expandedUrl = UrlShortener::decode($shortenedUrl);

        $this->assertNotNull($expandedUrl);
        $this->assertEquals($originalUrl, $expandedUrl);
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        UrlShortener::encode('invalid-url');
    }

    public function testDecodeNonExistentShortUrl()
    {
        $nonExistentShortUrl = 'https://short.url/non-existent';

        $expandedUrl = UrlShortener::decode($nonExistentShortUrl);

        $this->assertNull($expandedUrl);
    }
}
