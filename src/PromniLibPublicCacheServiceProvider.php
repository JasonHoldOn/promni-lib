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
    }
}