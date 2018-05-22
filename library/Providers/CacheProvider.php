<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/3/7
 * Time: 下午5:08
 */

namespace Library\Providers;

use Library\Contracts\ProviderContract;

class CacheProvider implements ProviderContract
{
    public function handle()
    {
        $di->setShared('cache', function() {
            $redisConfig = config('redis');
            // Cache data for one day by default
            $frontCache = new FrontendData(
                [
                    'lifetime' => $redisConfig['redis']['lifetime'],
                ]
            );
            // redis connection settings
            $cache = new BackendRedis(
                $frontCache,
                [
                    'host'       => $redisConfig['redis']['host'],
                    'port'       => $redisConfig['redis']['port'],
                    'auth'       => $redisConfig['redis']['auth'],
                    'persistent' => $redisConfig['redis']['persistent'],
                    'index'      => $redisConfig['redis']['index'],
                ]
            );
            return $cache;
        });
    }
}