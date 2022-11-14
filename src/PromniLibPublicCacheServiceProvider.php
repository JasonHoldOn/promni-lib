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
    }

    public function register()
    {
        /** @var Repository $config */
        $config = $this->app->get('config');
        $commonCacheConfig = $this->app->make('config')->get('promni-common-cache');

        /** redis配置 */
        $redisConfig = $commonCacheConfig['redis'] ?? [];
        $config->set(
            'database.redis.gm_public',
            [
                'host'     => $redisConfig['host'],
                'port'     => $redisConfig['port'],
                'database' => $redisConfig['database'],
                'password' => $redisConfig['password'],
                'options'  => [
                    'prefix' => $redisConfig['prefix'],
                ],
            ]
        );

        /** mysql数据库配置 */
        $mysqlCrmConfig = $commonCacheConfig['mysql-crm'] ?? [];
        $config->set(
            'database.connections.crm_public',
            [
                'driver'         => 'mysql',
                'host'           => $mysqlCrmConfig['host'],
                'port'           => $mysqlCrmConfig['port'],
                'database'       => $mysqlCrmConfig['database'],
                'username'       => $mysqlCrmConfig['username'],
                'password'       => $mysqlCrmConfig['password'],
                'unix_socket'    => $mysqlCrmConfig['unix_socket'],
                'charset'        => 'utf8mb4',
                'collation'      => 'utf8mb4_unicode_ci',
                'prefix'         => '',
                'prefix_indexes' => true,
                'strict'         => false,
                'engine'         => null,
                'options'        => extension_loaded('pdo_mysql') ? array_filter(
                    [
                        PDO::MYSQL_ATTR_SSL_CA => $mysqlCrmConfig['mysql_attr_ssl_ca'],
                    ]
                ) : [],
            ]
        );
    }
}