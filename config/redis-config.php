<?php
/**
 * redis配置
 *
 */

return [
    'gm_public' => [
        'host'     => env('REDIS_HOST', '127.0.0.1'),
        'port'     => env('REDIS_PORT', 6379),
        'database' => env('PROMNI_COMMON_CACHE_DB', 11),
        'password' => env('REDIS_PASSWORD', null),
        'options'  => [
            'prefix' => env('PROMNI_COMMON_CACHE_PREFIX', 'gm:'),
        ],
    ],
];