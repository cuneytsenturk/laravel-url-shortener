<?php

namespace CuneytSenturk\UrlShortener\Contracts;

use CuneytSenturk\UrlShortener\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class Driver
{
    /**
     * The settings data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Whether the store has changed since it was last loaded.
     *
     * @var bool
     */
    protected $unsaved = false;

    /**
     * Whether the settings data are loaded.
     *
     * @var bool
     */
    protected $loaded = false;

    public function encode($url, $default = null)
    {
        if (empty($url)) {
            return $url;
        }

        $short_url = $default;

        if (empty($default)) {
            $short_url = config('url_shortener.base_url') . '/' . Str::random(config('url_shortener.length'));
        }

        $this->set($url, $short_url);

        $this->save();

        return $short_url;
    }

    public function decode($url, $default = null)
    {
        return $this->get($url, $default);
    }

    /**
     * Get a specific key from the settings data.
     *
     * @param string|array $key
     * @param mixed        $default Optional default value.
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->load();

        return Arr::get($this->data, $key, $default);
    }

    /**
     * Set a specific key to a value in the settings data.
     *
     * @param string|array $key   Key string or associative array of key => value
     * @param mixed        $value Optional only if the first argument is an array
     */
    public function set($key, $value = null)
    {
        $this->load();

        $this->unsaved = true;

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Arr::set($this->data, $k, $v);
            }
        } else {
            Arr::set($this->data, $key, $value);
        }
    }

    /**
     * Determine if a key exists in the settings data.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $this->load();

        return Arr::has($this->data, $key);
    }

    /**
     * Unset a key in the settings data.
     *
     * @param string $key
     */
    public function forget($key)
    {
        $this->unsaved = true;

        if ($this->has($key)) {
            Arr::forget($this->data, $key);
        }
    }

    /**
     * Unset all keys in the settings data.
     *
     * @return void
     */
    public function forgetAll()
    {
        if (config('url_shortener.cache.enabled')) {
            Cache::forget($this->getCacheKey());
        }

        $this->unsaved = true;
        $this->data = [];
    }

    /**
     * Get all settings data.
     *
     * @return array|bool
     */
    public function all()
    {
        $this->load();

        return $this->data;
    }

    /**
     * Save any changes done to the settings data.
     *
     * @return void
     */
    public function save()
    {
        if (!$this->unsaved) {
            // either nothing has been changed, or data has not been loaded, so
            // do nothing by returning early
            return;
        }

        if (config('url_shortener.cache.enabled') && config('url_shortener.cache.auto_clear')) {
            Cache::forget($this->getCacheKey());
        }

        $this->write($this->data);
        $this->unsaved = false;
    }

    /**
     * Make sure data is loaded.
     *
     * @param $force Force a reload of data. Default false.
     */
    public function load($force = false)
    {
        if ($this->loaded && !$force) {
            return;
        }

        $driver_data = $this->readData();

        $this->data = (array) $driver_data;
        $this->loaded = true;
    }

    /**
     * Read data from driver or cache
     *
     * @return array
     */
    public function readData()
    {
        if (config('url_shortener.cache.enabled')) {
            return $this->readDataFromCache();
        }

        return $this->read();
    }

    /**
     * Read data from cache
     *
     * @return array
     */
    public function readDataFromCache()
    {
        return Cache::remember($this->getCacheKey(), config('url_shortener.cache.ttl'), function () {
            return $this->read();
        });
    }

    /**
     * Get cache key based on extra columns.
     *
     * @return string
     */
    public function getCacheKey()
    {
        $key = config('url_shortener.cache.key');

        return $key;
    }

    /**
     * Read data from driver.
     *
     * @return array
     */
    abstract protected function read();

    /**
     * Write data to driver.
     *
     * @param  array  $data
     *
     * @return void
     */
    abstract protected function write(array $data);
}
