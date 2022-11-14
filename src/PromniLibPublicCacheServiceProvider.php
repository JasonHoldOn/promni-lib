<?php


namespace Jason;


use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use PDO;

class PromniLibPublicCacheServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/promni-common-cache.php' => config_path('promni-common-cache.php'),
            ]
        );

        /** @var Repository $config */
        $config = $this->app->get('config');
        $config->set(
            'database.redis.gm_public',
            [
                'host'     => config('promni-common-cache.redis.host'),
                'port'     => config('promni-common-cache.redis.port'),
                'database' => config('promni-common-cache.redis.database'),
                'password' => config('promni-common-cache.redis.password'),
                'options'  => [
                    'prefix' => config('promni-common-cache.redis.prefix'),
                ],
            ]
        );

        $config->set(
            'database.connections.crm_public',
            [
                'driver'         => 'mysql',
                'host'           => config('promni-common-cache.mysql-crm.host'),
                'port'           => config('promni-common-cache.mysql-crm.port'),
                'database'       => config('promni-common-cache.mysql-crm.database'),
                'username'       => config('promni-common-cache.mysql-crm.username'),
                'password'       => config('promni-common-cache.mysql-crm.password'),
                'unix_socket'    => config('promni-common-cache.mysql-crm.unix_socket'),
                'charset'        => 'utf8mb4',
                'collation'      => 'utf8mb4_unicode_ci',
                'prefix'         => '',
                'prefix_indexes' => true,
                'strict'         => false,
                'engine'         => null,
                'options'        => extension_loaded('pdo_mysql') ? array_filter(
                    [
                        PDO::MYSQL_ATTR_SSL_CA => config('promni-common-cache.mysql-crm.mysql_attr_ssl_ca'),
                    ]
                ) : [],
            ]
        );
    }

    public function register()
    {
    }
}