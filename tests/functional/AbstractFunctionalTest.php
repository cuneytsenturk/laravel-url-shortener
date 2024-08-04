<?php

use CuneytSenturk\UrlShortener\Drivers\Database;

use PHPUnit\Framework\TestCase;
abstract class AbstractFunctionalTest extends TestCase
{
    abstract protected function createStore(array $data = []);

    protected function assertStoreEquals($store, $expected, $message = null)
    {
        $this->assertEquals($expected, $store->all(), $message);
        $store->save();
        $store = $this->createStore();
        $this->assertEquals($expected, $store->all(), $message);
    }

    protected function assertStoreKeyEquals($store, $key, $expected, $message = null)
    {
        $this->assertEquals($expected, $store->get($key), $message);
        $store->save();
        $store = $this->createStore();
        $this->assertEquals($expected, $store->get($key), $message);
    }

    /** @test */
    public function store_is_initially_empty()
    {
        $store = $this->createStore();
        $this->assertEquals([], $store->all());
    }

    /** @test */
    public function written_changes_are_saved()
    {
        $store = $this->createStore();
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123');
        $this->assertStoreKeyEquals($store, 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123');
    }

    /** @test */
    public function nested_keys_are_nested()
    {
        $store = $this->createStore();
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz');
        $this->assertStoreEquals($store, ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']]);
    }

    /** @test */
    public function cannot_set_nested_key_on_non_array_member()
    {
        $store = $this->createStore();
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123');
        $this->setExpectedException('UnexpectedValueException', 'Non-array segment encountered');
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz');
    }

    /** @test */
    public function can_forget_key()
    {
        $store = $this->createStore();
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123');
        $store->set('https://short.url/abc123', 'baz');
        $this->assertStoreEquals($store, ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123', 'https://short.url/abc123' => 'baz']);

        $store->forget('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter');
        $this->assertStoreEquals($store, ['https://short.url/abc123' => 'baz']);
    }

    /** @test */
    public function can_forget_nested_key()
    {
        $store = $this->createStore();
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz');
        $store->set('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.baz', 'https://short.url/abc123');
        $store->set('https://short.url/abc123.https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'baz');
        $this->assertStoreEquals($store, [
            'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => [
                'https://short.url/abc123' => 'baz',
                'baz' => 'https://short.url/abc123',
            ],
            'https://short.url/abc123' => [
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'baz',
            ],
        ]);

        $store->forget('https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123');
        $this->assertStoreEquals($store, [
            'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => [
                'baz' => 'https://short.url/abc123',
            ],
            'https://short.url/abc123' => [
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'baz',
            ],
        ]);

        $store->forget('https://short.url/abc123.https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter');
        $expected = [
            'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => [
                'baz' => 'https://short.url/abc123',
            ],
            'https://short.url/abc123' => [
            ],
        ];
        if ($store instanceof Database) {
            unset($expected['https://short.url/abc123']);
        }
        $this->assertStoreEquals($store, $expected);
    }

    /** @test */
    public function can_forget_all()
    {
        $store = $this->createStore(['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123']);
        $this->assertStoreEquals($store, ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123']);
        $store->forgetAll();
        $this->assertStoreEquals($store, []);
    }
}
