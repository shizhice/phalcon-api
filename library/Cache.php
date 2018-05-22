<?php
namespace  Library;
/**
 * cache class
 */
use \Phalcon\Mvc\Controller;
class Cache extends Controller
{
    protected static $_instance;

    public static function init($name='cache')
    {
        return self::getInstance()->{$name};
    }

    private static function getInstance()
    {
        self::$_instance or self::$_instance = new static();

        return self::$_instance;
    }
}