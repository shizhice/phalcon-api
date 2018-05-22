<?php
define('APP_START_AT', microtime(true));
define('APP_START_MEM', memory_get_usage());

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);

$app = require BASE_PATH.'/bootstrap/bootstrap.php';

$app->run();