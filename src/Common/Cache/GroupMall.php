<?php


namespace Jason\Common\Cache;


use Illuminate\Support\Facades\Redis;

class GroupMall
{
    public static function put(string $key, $value, int $seconds = -1)
    {
        if ($seconds <= 0) {
            return Redis::connection('gm_public')->set($key, serialize($value));
        }
        return Redis::connection('gm_public')->setex($key, $seconds, serialize($value));
    }

    public static function get(string $key)
    {
        $cache = Redis::connection('gm_public')->get($key);
        if (!is_null($cache)) {
            return unserialize($cache);
        }
        return null;
    }
}