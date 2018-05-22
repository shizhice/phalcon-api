<?php
use Library\Route;
use Library\Contracts\Middleware;
use Phalcon\Mvc\Controller as ControllerBase;

abstract class Controller extends ControllerBase
{
    /**
     * before execute route
     * @author shizhice <shizhice@gmial.com>
     * @return mixed
     */
    final public function beforeExecuteRoute()
    {
        // 获取当前匹配上的路由
        $matchedRouter = $this->router->getMatchedRoute();
        // 获取路由中间件配置
        $middleware = Route::getMiddleware();
        $middleware['validate'] = Route::getValidate();

        if (isset($middleware['overallMiddleware'])) {
            foreach ($middleware['overallMiddleware'] as $currentOverallMiddleware) {
                $currentMiddlewareInstance = new $currentOverallMiddleware;
                if (!$currentMiddlewareInstance instanceof Middleware) {
                    throw new \Exception("[{$currentOverallMiddleware}]没有实现接口[Library\\Contracts\\Middleware]");
                }
                //执行中间件，如返回值为false,则终止后续操作
                $result = $currentMiddlewareInstance->handle(request());
                if ($result === false || $result instanceof \Phalcon\Http\Response) {
                    return false;
                }
            }
        }

        //判断当前路由是否绑定中间件
        if (isset($matchedRouter->middleware)) {
            //遍历当前路由所有中间件
            foreach ($matchedRouter->middleware as $middle) {
                list($middlewareType,$currentMiddleware) = explode("@",$middle);
                //验证当前中间件是否已经注册
                if (!isset($middleware[$middlewareType][$currentMiddleware])) {
                    throw new \Exception("\"$middle\"中间件不存在");
                }
                $currentMiddleware = $middleware[$middlewareType][$currentMiddleware];
                $currentMiddlewareInstance = new $currentMiddleware;
                if (!$currentMiddlewareInstance instanceof Middleware) {
                    throw new \Exception("[{$middleware[$middle]}]没有实现接口[Library\\Contracts\\Middleware]");
                }
                //执行中间件，如返回值为false,则终止后续操作
                $result = $currentMiddlewareInstance->handle(request());
                if ($result === false || $result instanceof \Phalcon\Http\Response) {
                    return false;
                }
            }
        }

        // 判断是否存在自定义中间件，如果有调用
        if (method_exists($this, '_beforeExecuteRoute')) {
            if ($this->_beforeExecuteRoute($this->dispatcher) === false) {
                return false;
            }
        }
        return true;
    }
}
