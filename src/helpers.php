<?php

if (!function_exists('url_shortener')) {
    /**
     * Get the Menu instance or render
     *
     * @param string $name
     *
     * @return mixed
     */
    function url_shortener($url = null, $method = 'encode')
    {
        $url_shortener = app('url_shortener');
        
        if (is_null($url)) {
            return $url_shortener;
        }
        
        return $url_shortener->$method($url);
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
    function url_shortener_encode($url = null)
    {
        return url_shortener($url);
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
    function url_shortener_decode($url = null)
    {
        return url_shortener($url, 'decode');
    }
}
