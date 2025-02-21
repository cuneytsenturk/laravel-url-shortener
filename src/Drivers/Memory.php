<?php

namespace CuneytSenturk\UrlShortener\Drivers;

use CuneytSenturk\UrlShortener\Contracts\Driver;

class Memory extends Driver
{
    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->data = $data;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function read()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $data)
    {
        // do nothing
    }
}
