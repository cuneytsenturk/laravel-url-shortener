<?php

if (!function_exists('url_shortener')) {
    /**
     * Get the Menu instance or render
     *
     * @param string $name
     *
     * @return mixed
     */
    function url_shortener($url = null, $default = '', $method = 'encode')
    {
        $url_shortener = app('url_shortener');
        
        if (is_null($url)) {
            return $url_shortener;
        }
        
        return $url_shortener->$method($url, $default);
    }
}

if (!function_exists('url_shortener_encode')) {
    /**
     * Get the Menu instance or render
     *
     * @param string $name
     *
     * @return mixed
     */
    function url_shortener_encode($url = null, $default = '')
    {
        return url_shortener($url, $default);
    }
}

if (!function_exists('url_shortener_decode')) {
    /**
     * Get the Menu instance or render
     *
     * @param string $name
     *
     * @return mixed
     */
    function url_shortener_decode($url = null, $default = '')
    {
        return url_shortener($url, $default, 'decode');
    }
}
