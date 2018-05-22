<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/21
 * Time: 下午3:57
 */

namespace Library\Providers;


use Library\Contracts\ProviderContract;
use Illuminate\Database\Capsule\Manager as Capsule;
use Shizhice\Support\Config;

class EloquentProvider implements ProviderContract
{
    public function handle()
    {
        // Eloquent ORM
        $capsule = new Capsule;

        $container = $capsule->getContainer();

        $defaultConnection = Config::get('database.default');

        $databaseConfig = Config::get('database.connections');

        $databaseConfig['default'] = $databaseConfig[$defaultConnection];

        $container->config['database.connections'] = $databaseConfig;

        $capsule->setContainer($container);

        $capsule->bootEloquent();
    }
}