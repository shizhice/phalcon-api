<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs([
    APP_PATH.'/Http/Controller',
])->registerNamespaces(
    [
        'App' => BASE_PATH . '/app/',
        'Library' => BASE_PATH . '/library/',
    ]
)->register();

require BASE_PATH.'/vendor/autoload.php';

$app = \Library\App::getInstance();

$app->setConfigPath(BASE_PATH."/config")
    ->register(\Library\Providers\LoadEnv::class)
    ->register(\Library\Providers\ExceptionHandler::class)
    ->register(\Library\Providers\EloquentProvider::class)
    ->register(\Library\Providers\ViewProvider::class)
    ->register(\Library\Providers\RouteProvider::class);

return $app;