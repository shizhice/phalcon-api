<?php
namespace Library;

use Shizhice\Support\Config;
use Phalcon\Di\FactoryDefault as Di;
use Library\Contracts\ProviderContract;
use \Phalcon\Mvc\Application;

class App
{
    protected static $instance;

    protected $uuid;
    protected $lifeStartAt;
    protected $lifeEndAt;
    protected $useMemory;
    protected $useTime;
    protected $throughputRate;

    protected $application;

    /**
     * App constructor.
     * @throws \Exception
     */
    private function __construct()
    {
        // 初始化
        $this->beginLife();
    }

    /**
     * before application run
     */
    private function beginLife()
    {
        $this->lifeStartAt = APP_START_AT ?: microtime(true);
        $this->uuid = self::guid();
    }

    /**
     * register provider
     * @param $class
     * @return $this
     */
    public function register($class)
    {
        $provider = new $class;

        if ($provider instanceof ProviderContract) {
            $provider->handle();
        }

        return $this;
    }

    /**
     * the app run
     */
    public function run()
    {
        $response = $this->handle();
        echo $response->getContent();

        $this->afterLife();
    }

    /**
     * after app run
     */
    private function afterLife()
    {
        $this->useMemory = self::getUseMem();
        $this->useTime = self::getUseTime();
        $this->throughputRate = self::getThroughputRate($this->useTime);
    }

    /**
     * 统计从开始到统计时的时间（微秒）使用情况 返回值以秒为单位
     * @param int $dec
     * @return string
     */
    public static function getUseTime($dec = 6)
    {
        return number_format((microtime(true) - APP_START_AT), $dec);
    }

    /**
     * 获取当前访问的吞吐率情况
     * @param null $useTime
     * @return string
     */
    public static function getThroughputRate($useTime = null)
    {
        return number_format(1 / (! is_null($useTime) ? $useTime : self::getUseTime()), 2) . ' req/s';
    }

    /**
     * get use memory
     * @param int $dec
     * @return string
     */
    public static function getUseMem($dec = 2)
    {
        $size = memory_get_usage() - APP_START_MEM;
        $a    = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pos  = 0;

        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }

        return round($size, $dec) . " " . $a[$pos];
    }

    /**
     * make a guid
     * @return string
     */
    public static function guid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid   = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }

    /**
     * set config path
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function setConfigPath($path)
    {
        Config::setConfigPath($path);

        return $this;
    }

    /**
     * get app instance
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
            self::$instance->application = new Application;
            self::$instance->application->setDi(new Di);
        }

        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    public function __clone()
    {
        throw new \Exception('clone is deny.');
    }

    /**
     * get app attribute
     * @param $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return self::$instance->{$attribute};
        }

        return self::$instance->application->{$attribute};
    }

    public function __call($name, $arguments)
    {
        return self::$instance->application->{$name}(...$arguments);
    }

}