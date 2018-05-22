<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/21
 * Time: 上午10:24
 */

namespace Library\Providers;


use Shizhice\Support\Config;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Library\Contracts\ProviderContract;

class ExceptionHandler implements ProviderContract
{
    public function handle()
    {
        if (! Config::get('app.debug')) {
            ini_set('display_errors', 'Off');
        } elseif (! IS_CLI) {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->register();
        }
    }
}