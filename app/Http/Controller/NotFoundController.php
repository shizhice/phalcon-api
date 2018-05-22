<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/22
 * Time: 下午12:56
 */

use Library\Response;

class NotFoundController
{
    public function indexAction()
    {
        return Response::json(Response::HTTP_NOT_FOUND);
    }
}