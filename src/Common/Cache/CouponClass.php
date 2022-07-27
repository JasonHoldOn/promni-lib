<?php

namespace Jason\Common\Cache;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CouponClass extends Cache
{
    public static $redisConnection = 'gm_public';
    public static $dbConnection    = 'crm_public';

    /**
     * 获取优惠券所有信息
     * @param int    $groupCode
     * @param string $couponId
     * @return array
     */
    public static function getCouponClassInfo(int $groupCode, string $couponId): array
    {
        $couponSimpleInfo = self::getCouponClassSimpleInfo($groupCode, $couponId);
        $couponUseInfo = self::getCouponClassUseInfo($groupCode, $couponId);
        return array_merge($couponSimpleInfo, $couponUseInfo);
    }

    /**
     * 获取优惠券基本信息
     * @param int    $groupCode
     * @param string $couponId
     * @return array
     */
    public static function getCouponClassSimpleInfo(int $groupCode, string $couponId): array
    {
        $key = self::generateCouponSimpleInfoCacheKey($groupCode, $couponId);
        $returnData = (array)parent::get($key);
        if (!$returnData) {
            [$returnData,] = self::generateCouponClassCache($groupCode, $couponId);
        }

        return $returnData;
    }

    /**
     * 获取优惠券使用信息
     * @param int    $groupCode
     * @param string $couponId
     * @return array
     */
    public static function getCouponClassUseInfo(int $groupCode, string $couponId): array
    {
        $key = self::generateCouponUseInfoCacheKey($groupCode, $couponId);
        $returnData = (array)parent::get($key);
        if (!$returnData) {
            [, $returnData] = self::generateCouponClassCache($groupCode, $couponId);
        }

        return $returnData;
    }

    /**
     * 生成优惠券缓存
     * @param int    $groupCode
     * @param string $couponId
     * @return array
     */
    public static function generateCouponClassCache(int $groupCode, string $couponId): array
    {
        $tableName = 'promni_coupon_service_' . $groupCode;
        $couponClass = DB::connection(self::$dbConnection)
                         ->table($tableName)
                         ->where('id', $couponId)
                         ->first();

        $couponSimpleInfo = $couponUseInfo = [];
        if ($couponClass) {
            $filedList = Schema::getColumnListing($tableName);
            $couponUseInfoFieldList = ['config_json', 'use_articles'];
            foreach ($filedList as $field) {
                if (in_array($field, $couponUseInfoFieldList, true)) {
                    $couponUseInfo[$field] = $couponClass->{$field};
                } else {
                    $couponSimpleInfo[] = $couponClass->{$field};
                }
            }

            parent::put(self::generateCouponSimpleInfoCacheKey($groupCode, $couponId), $couponSimpleInfo);
            parent::put(self::generateCouponUseInfoCacheKey($groupCode, $couponId), $couponUseInfo);
        }

        return [$couponSimpleInfo, $couponUseInfo];
    }

    /**
     * @param int    $groupCode
     * @param string $couponId
     * @return string
     */
    private static function generateCouponSimpleInfoCacheKey(int $groupCode, string $couponId)
    {
        return 'coupon_simple_info:' . $groupCode . ':' . $couponId;
    }

    /**
     * @param int    $groupCode
     * @param string $couponId
     * @return string
     */
    private static function generateCouponUseInfoCacheKey(int $groupCode, string $couponId)
    {
        return 'coupon_use_info:' . $groupCode . ':' . $couponId;
    }
}