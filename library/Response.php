<?php

namespace Library;

use Library\Contracts\HttpMessageInterface;

class Response implements HttpMessageInterface
{
    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    |
    | Response 响应
    |
    |
    */

    /**
     * redirect
     * @param string $uri
     * @return mixed
     */
    public static function redirect($uri = '/')
    {
        return app("response")->redirect($uri);
    }

    /**
     * json return
     * @param int $statusCode
     * @param string $message
     * @param array $data
     * @param int $code
     * @return mixed
     * @throws \Exception
     */
    public static function json($statusCode = 200, $message = '', $data = [], $code = 0)
    {
        if (! isset(Response::STATUS_TEXTS[$statusCode])) {
            throw new \Exception('error http status code.');
        }

        app("response")->setContentType('application/json', 'UTF-8');

        app("view")->disable();

        app("response")->setJsonContent([
            'status_code' => $statusCode,
            'code' => $code,
            'message' => $message ?: Response::STATUS_TEXTS[$statusCode],
            'data' => $data,
        ], JSON_UNESCAPED_UNICODE);

        return app("response")->send();
    }
}
