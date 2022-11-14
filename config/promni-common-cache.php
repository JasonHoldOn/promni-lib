<?php
/**
 * 公共缓存配置
 * User: songxudong@promni.cn
 * Date: 2022/11/14
 * Time: 14:56
 */

return [
    /** 共用redis配置 */
    'reids'     => [
        'host'     => env('REDIS_HOST', '127.0.0.1'),
        'port'     => env('REDIS_PORT', 6379),
        'database' => env('PROMNI_COMMON_CACHE_DB', 11),
        'password' => env('REDIS_PASSWORD', null),
        'prefix'   => env('PROMNI_COMMON_CACHE_PREFIX', 'gm:'),
    ],

    /** mysql数据库配置 */
    'mysql-crm' => [
        'host'              => env('CRM_DB_HOST', '127.0.0.1'),
        'port'              => env('CRM_DB_PORT', '3306'),
        'database'          => env('CRM_DB_DATABASE', 'forge'),
        'username'          => env('CRM_DB_USERNAME', 'forge'),
        'password'          => env('CRM_DB_PASSWORD', ''),
        'unix_socket'       => env('CRM_DB_SOCKET', ''),
        'mysql_attr_ssl_ca' => env('MYSQL_ATTR_SSL_CA'),
    ],
];