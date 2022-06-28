<?php


namespace Jason\Common\Cache;


use Illuminate\Support\Facades\Redis;

class Cache
{
    static $connection = 'common';

    public static function put(string $key, $value, int $seconds = -1)
    {
        if ($seconds <= 0) {
            return Redis::connection(static::$connection)->set($key, serialize($value));
        }

        return Redis::connection(static::$connection)->setex($key, $seconds, serialize($value));
    }

    public static function get(string $key)
    {
        $cache = Redis::connection(static::$connection)->get($key);
        if (!is_null($cache)) {
            return unserialize($cache);
        }

        return null;
    }
}