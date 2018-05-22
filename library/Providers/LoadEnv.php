<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/21
 * Time: 上午11:01
 */

namespace Library\Providers;


use Dotenv\Dotenv;
use Library\Contracts\ProviderContract;

class LoadEnv implements ProviderContract
{
    public function handle()
    {
        $dotEnv = new Dotenv(BASE_PATH);
        $dotEnv->load();
    }
}