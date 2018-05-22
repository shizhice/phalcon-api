<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/3/7
 * Time: 下午5:07
 */

namespace Library\Providers;


use Library\App;
use Library\Route;
use Library\Contracts\ProviderContract;

class RouteProvider implements ProviderContract
{
    public function handle()
    {
        App::getInstance()->getDi()->setShared('router',function(){
            /**
             * load router
             */
            return Route::load();
        });
    }
}