<?php

namespace Jason\Common\Cache;

class Common extends Cache
{
    protected static $redisConnection = 'gm_public';

    public static function getGroupCache(int $groupCode, string $key, string $tag = '')
    {
        return parent::get(self::generateCacheKey('g', $groupCode, $key, $tag));
    }

    public static function setGroupCache(int $groupCode, string $key, $cacheValue, string $tag = '', int $seconds = -1)
    {
        return parent::put(self::generateCacheKey('g', $groupCode, $key, $tag), $cacheValue, $seconds);
    }

    public static function delGroupCache(int $groupCode, string $key, string $tag = '')
    {
        return parent::del(self::generateCacheKey('g', $groupCode, $key, $tag));
    }

    public static function batchDelGroupCache(int $groupCode, string $keyMatch, string $tag = '')
    {
        return parent::batchDel(self::generateCacheKey('g', $groupCode, $keyMatch, $tag));
    }

    public static function getMallCache(int $mallCode, string $key, string $tag = '')
    {
        return parent::get(self::generateCacheKey('m', $mallCode, $key, $tag));
    }

    public static function setMallCache(int $mallCode, string $key, $cacheValue, string $tag = '', int $seconds = -1)
    {
        return parent::put(self::generateCacheKey('m', $mallCode, $key, $tag), $cacheValue, $seconds);
    }

    public static function delMallCache(int $mallCode, string $key, string $tag = '')
    {
        return parent::del(self::generateCacheKey('m', $mallCode, $key, $tag));
    }

    public static function batchDelMallCache(int $mallCode, string $keyMatch, string $tag = '')
    {
        return parent::batchDel(self::generateCacheKey('m', $mallCode, $keyMatch, $tag));
    }

    public static function generateCacheKey(string $type, int $gmCode, string $key, string $tag = '')
    {
        if (!$tag) {
            $tag = config('app.name');
        }
        $tag = $tag ?: 'default';
        return $tag . ':' . $type . $gmCode . ':' . $key;
    }
}