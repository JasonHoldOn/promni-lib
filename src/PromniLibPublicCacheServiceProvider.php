<?php


namespace Jason;


use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class PromniLibPublicCacheServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        /** @var Repository $config */
        $config = $this->app->get('config');
        $config->set(
            'database.redis.gm_public',
            [
                'host'     => env('REDIS_HOST', '127.0.0.1'),
                'port'     => env('REDIS_PORT', 6379),
                'database' => '11',
                'password' => env('REDIS_PASSWORD', null),
                'options'  => [
                    'prefix' => 'gm:',
                ],
            ]
        );

        $config->set(
            'database.connections.crm_public',
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
                        \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                    ]
                ) : [],
            ]
        );
    }
}