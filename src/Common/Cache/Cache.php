<?php


namespace Jason\Common\Cache;


use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;

class Cache
{
    protected static $redisConnection = 'default';

    /**
     * @return Connection
     */
    private static function getConnection()
    {
        return Redis::connection(static::$redisConnection);
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
        $redisPrefix = self::getConnection()->getOptions()->prefix->getPrefix();
        $matchKey = $redisPrefix . $matchKey;
        $delNums = 0;
        while (true) {
            [$cursor, $result] = self::getConnection()->scan($cursor, ['match' => $matchKey, 'count' => 100]);
            if (is_array($result) && $result) {
                $delKeys = $result;
                if ($redisPrefix) {
                    $delKeys = [];
                    foreach ($result as $key) {
                        /** 需要替换掉前缀后删除 */
                        $delKeys[] = mb_substr($key, mb_strlen($redisPrefix));
                    }
                }
                $delResult = self::getConnection()->del($delKeys);
                $delNums += $delResult;
            }

            if (!$cursor) {
                break;
            }
        }

        return $delNums;
    }
}