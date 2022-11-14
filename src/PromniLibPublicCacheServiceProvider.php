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
        $config->set('database.redis.gm_public', $commonCacheConfig['redis']);

        /** mysql数据库配置 */
        $config->set('database.connections.crm_public', $commonCacheConfig['mysql-crm']);
    }
}