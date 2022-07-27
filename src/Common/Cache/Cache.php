<?php


namespace Jason\Common\Cache;


use Illuminate\Support\Facades\Redis;

class Cache
{
    public static $redisConnection = 'default';

    public static function put(string $key, $value, int $seconds = -1)
    {
        if ($seconds <= 0) {
            return Redis::connection(static::$redisConnection)->set($key, serialize($value));
        }

        return Redis::connection(static::$redisConnection)->setex($key, $seconds, serialize($value));
    }

    public static function get(string $key)
    {
        $cache = Redis::connection(static::$redisConnection)->get($key);
        if (!is_null($cache)) {
            return unserialize($cache);
        }

        return null;
    }
}