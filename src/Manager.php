<?php

namespace CuneytSenturk\UrlShortener;

use CuneytSenturk\UrlShortener\Drivers\Database;
use CuneytSenturk\UrlShortener\Drivers\Json;
use CuneytSenturk\UrlShortener\Drivers\Memory;
use Illuminate\Support\Manager as BaseManager;

class Manager extends BaseManager
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The application instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app = null)
    {
        $this->container = $app ?? app();

        parent::__construct($this->container);
    }

    public function getDefaultDriver()
    {
        return config('url_shortener.driver');
    }

    public function createJsonDriver()
    {
        $path = config('url_shortener.json.path');

        return new Json($this->container['files'], $path);
    }

    public function createDatabaseDriver()
    {
        $connection = $this->container['db']->connection(config('url_shortener.database.connection'));
        $table = config('url_shortener.database.table');
        $key = config('url_shortener.database.key');
        $value = config('url_shortener.database.value');
        $encryptedKeys = config('url_shortener.encrypted_keys');

        return new Database($connection, $table, $key, $value, $encryptedKeys);
    }

    public function createMemoryDriver()
    {
        return new Memory();
    }

    public function createArrayDriver()
    {
        return $this->createMemoryDriver();
    }
}
