<?php


namespace Jason\Common\Cache;


use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;

class Cache
{
    protected static $redisConnection = 'default';

    /**
     * @var array
     */
    private static $connections;

    /**
     * @return Connection
     */
    private static function getConnection()
    {
        $connection = self::$connections[static::$redisConnection] ?? null;
        if (!$connection) {
            $connection = Redis::connection(static::$redisConnection);
            self::$connections[static::$redisConnection] = $connection;
        }
        return $connection;
    }

    public static function put(string $key, $value, int $seconds = -1)
    {
        if ($seconds <= 0) {
            return self::getConnection()->set($key, serialize($value));
        }

        return self::getConnection()->setex($key, $seconds, serialize($value));
    }

    public static function get(string $key)
    {
        $cache = self::getConnection()->get($key);
        if (!is_null($cache)) {
            return unserialize($cache);
        }

        return null;
    }

    public static function del(string $key)
    {
        return self::getConnection()->del($key);
    }

    public static function batchDel(string $matchKey)
    {
        $cursor = 0;
        while (true) {
            [$cursor, $result] = self::getConnection()->scan($cursor, ['match' => $matchKey, 'count' => 50]);
            if (is_array($result)) {
                self::getConnection()->del($result);
            }

            if (!$cursor) {
                break;
            }
        }

        return true;
    }
}