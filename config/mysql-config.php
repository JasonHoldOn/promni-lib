<?php
/**
 * mysql数据库配置
 *
 */

return [
    'crm_public' =>
        [
            'driver'         => 'mysql',
            'host'           => env('CRM_DB_HOST', '127.0.0.1'),
            'port'           => env('CRM_DB_PORT', '3306'),
            'database'       => env('CRM_DB_DATABASE', 'forge'),
            'username'       => env('CRM_DB_USERNAME', 'forge'),
            'password'       => env('CRM_DB_PASSWORD', ''),
            'unix_socket'    => env('CRM_DB_SOCKET', ''),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_unicode_ci',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => false,
            'engine'         => null,
            'options'        => extension_loaded('pdo_mysql') ? array_filter(
                [
                    PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]
            ) : [],
        ],
];