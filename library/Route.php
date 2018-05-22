<?php

namespace Library;

use Shizhice\Support\Config;
use \Phalcon\Mvc\Router as baseRouter;

class Route extends baseRouter
{
    /*
    |--------------------------------------------------------------------------
    | router
    |--------------------------------------------------------------------------
    |
    | 优化phalcon路由类，并完善路由中间件功能，如需其他功能，请使用phalcon的设置方式
    |
    |
    */

    static private $_router;
    static private $_group;
    static private $_instance;
    static private $_validate;
    static private $_middleware;

    /**
     * get middleware
     * @author shizhice<shizhice@gmail.com>
     * @return mixed
     */
    static public function getMiddleware()
    {
        return self::$_middleware;
    }

    /**
     * get validate
     * @author shizhice<shizhice@gmail.com>
     * @return mixed
     */
    static public function getValidate()
    {
        return self::$_validate;
    }
    /**
     * load router
     * @author shizhice<shizhice@gmail.com>
     */
    static public function load()
    {
        if (file_exists(BASE_PATH.'/bootstrap/cache/router.php')) {
            include BASE_PATH.'/bootstrap/cache/router.php';
        }else{
            foreach(glob(BASE_PATH.'/routes/*.php') as $routerFile) {
                require_once $routerFile;
            }
        }

        self::$_middleware = Config::get('middleware');
        self::$_validate = Config::get('validate');

        self::getInstance()->notFound([
            'controller' => 'NotFound',
            'action' => 'index'
        ]);

        self::getInstance()->removeExtraSlashes(true);

        return self::getInstance();
    }

    /**
     * router group
     * @param $middleware
     * @param \Closure $callback
     * @author shizhice<shizhice@gmail.com>
     * @return null
     */
    static public function group($middleware,\Closure $callback)
    {
        self::$_group = [];

        foreach ($middleware as &$item) {
            $item = 'routeMiddleware@'.$item;
        }

        $callback();

        foreach (self::$_group as &$router) {
            $router->middleware = isset($router->middleware)
                ? array_merge($middleware, $router->middleware)
                : $middleware;
        }

        return null;
    }

    /**
     * middleware
     * @param array $middleware
     * @author shizhice<shizhice@gmail.com>
     * @return Route
     */
    public function middleware(array $middleware)
    {
        foreach ($middleware as &$item) {
            $item = 'routeMiddleware@'.$item;
        }

        self::$_router->middleware = isset(self::$_router->middleware)
            ? array_merge(self::$_router->middleware, $middleware)
            : $middleware;

        return self::getInstance();
    }

    /**
     * validate
     * @param array $validate
     * @return Route
     */
    public function validate(array $validate)
    {
        foreach ($validate as &$item) {
            $item = 'validate@'.$item;
        }

        self::$_router->middleware = isset(self::$_router->middleware)
            ? array_merge(self::$_router->middleware, $validate)
            : $validate;

        return self::getInstance();
    }

    /**
     * get instance
     * @author shizhice<shizhice@gmail.com>
     * @return Route
     */
    static private function getInstance()
    {
        self::$_instance or self::$_instance = new self(false);

        return self::$_instance;
    }

    /**
     * __callStatic
     * @param $name
     * @param $arguments
     * @author shizhice<shizhice@gmail.com>
     * @return Route
     */
    static public function __callStatic($name, $arguments)
    {
        self::$_router = self::getInstance()->{'add'.ucfirst($name)}(...$arguments);
        self::$_group[] = self::$_router;

        return self::getInstance();
    }
}
