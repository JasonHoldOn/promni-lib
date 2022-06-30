<?php


namespace Jason\Utils;


use Illuminate\Support\Str;

class Tools
{
    public static function camelNull2str(array $data, $unCamelCase = []): array
    {
        $wrapData = [];
        foreach ($data as $k => $v) {
            if (!in_array($k, $unCamelCase)) {
                $k = Str::camel($k);
            }
            if (is_array($v)) {
                $wrapData[$k] = self::camelNull2str($v, $unCamelCase);
            } else {
                if (is_null($v)) {
                    $wrapData[$k] = '';
                } else {
                    $wrapData[$k] = $v;
                }
            }
        }

        return $wrapData;
    }
}