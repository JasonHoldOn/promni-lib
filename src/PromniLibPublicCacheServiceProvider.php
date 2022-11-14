<?php


namespace Jason;


use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class PromniLibPublicCacheServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $redisConfig = realpath(__DIR__ . '/../config/redis-config.php');
        $mysqlConfig = realpath(__DIR__ . '/../config/mysql-config.php');

//        $this->publishes(
//            [
//                $redisConfig => config_path('promni-common-cache-redis-config.php'),
//                $mysqlConfig => config_path('promni-common-cache-mysql-config.php'),
//            ]
//        );

        $this->mergeConfigFrom($redisConfig, 'database.redis');
        $this->mergeConfigFrom($mysqlConfig, 'database.connections');
    }
}