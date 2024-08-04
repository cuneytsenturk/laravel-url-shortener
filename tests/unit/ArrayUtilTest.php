<?php

use CuneytSenturk\UrlShortener\Support\Arr;

use PHPUnit\Framework\TestCase;
class ArrayUtilityTest extends TestCase
{
    /**
     * @test
     * @dataProvider getGetData
     */
    public function getReturnsCorrectValue(array $data, $key, $expected)
    {
        $this->assertEquals($expected, Arr::get($data, $key));
    }

    public function getGetData()
    {
        return [
            [
                [],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                null
            ],
            
            [
                [
                    'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'
                ],

                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                'https://short.url/abc123'
            ],

            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'], 'https://short.url/abc123', null],

            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', null],

            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz'],

            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.baz', null],

            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', ['https://short.url/abc123' => 'baz']],

            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123', 'https://short.url/abc123' => 'baz'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', 'https://short.url/abc123'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123', 'https://short.url/abc123' => 'baz'],
            ],

            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz'], 'https://short.url/abc123' => 'baz'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'https://short.url/abc123'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz'], 'https://short.url/abc123' => 'baz'],
            ],

            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz'], 'https://short.url/abc123' => 'baz'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']],
            ],

            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz'], 'https://short.url/abc123' => 'baz'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz'],
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz'], 'baz' => null],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getSetData
     */
    public function setSetsCorrectKeyToValue(array $input, $key, $value, array $expected)
    {
        Arr::set($input, $key, $value);
        $this->assertEquals($expected, $input);
    }

    public function getSetData()
    {
        return [
            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                'baz',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'baz'],
            ],
            [
                [],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                'https://short.url/abc123',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'],
            ],
            [
                [],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123',
                'baz',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']],
            ],
            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.baz',
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz', 'baz' => 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter']],
            ],
            [
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.baz.https://short.url/abc123',
                'baz',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz', 'baz' => ['https://short.url/abc123' => 'baz']]],
            ],
            [
                [],
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123.baz',
                'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter',
                ['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => ['baz' => 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter']]],
            ],
        ];
    }

    /** @test */
    public function setThrowsExceptionOnNonArraySegment()
    {
        $data = [
            'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'
        ];

        $this->setExpectedException('UnexpectedValueException', 'Non-array segment encountered');

        Arr::set($data, 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', 'baz');
    }

    /**
     * @test
     * @dataProvider getHasData
     */
    public function hasReturnsCorrectly(array $input, $key, $expected)
    {
        $this->assertEquals($expected, Arr::has($input, $key));
    }

    public function getHasData()
    {
        return [
            [[], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', false],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', true],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'], 'https://short.url/abc123', false],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => 'https://short.url/abc123'], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', false],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', true],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.baz', false],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => 'baz']], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', true],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => null], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter', true],
            [['https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter' => ['https://short.url/abc123' => null]], 'https://www.example.com/articles/2024/08/04/the-impact-of-technology?utm_source=newsletter.https://short.url/abc123', true],
        ];
    }
}
