<?php
namespace Library;


use Shizhice\Support\Arr;

class Request
{
    /**
     * get request query data
     * @param string|null $name
     * @param null $default
     * @return array
     */
    static public function get(string $name = null,$default = null)
    {
        if (is_null($name)) {
            return Arr::except(app('request')->getQuery(), '_url');
        }

        return app('request')->getQuery($name, null, $default);
    }

    /**
     * get request delete data
     * @param string|null $name
     * @param null $default
     * @return array
     */
    static public function delete(string $name = null,$default = null)
    {
        if (is_null($name)) {
            return Arr::except(app('request')->getQuery(), '_url');
        }

        return app('request')->getQuery($name, null, $default);
    }

    /**
     * get request post data
     * @param string|null $name
     * @param null $default
     * @return array
     */
    static public function post(string $name = null,$default = null)
    {
        if (is_null($name)) {
            return app('request')->getPost();
        }

        return app('request')->getPost($name, null, $default);
    }

    /**
     * get request put data
     * @param string|null $name
     * @param null $default
     * @return array
     */
    static public function put(string $name = null,$default = null)
    {
        if (is_null($name)) {
            return app('request')->getPut();
        }

        return app('request')->getPut($name, null, $default);
    }

    /**
     * get request put data
     * @return array
     */
    static public function all()
    {
        return app('request')->get();
    }
}