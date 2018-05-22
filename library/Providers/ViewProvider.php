<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/3/7
 * Time: 下午5:05
 */

namespace Library\Providers;


use Library\App;
use Library\Contracts\ProviderContract;

class ViewProvider implements ProviderContract
{
    public function handle()
    {
        App::getInstance()->getDi()->setShared('view',function () {
            return new \Phalcon\Mvc\View;
        });
    }
}