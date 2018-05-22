<?php
/**
 * Created by PhpStorm.
 * User: shizhice
 * Date: 2018/5/21
 * Time: 下午4:25
 */

class IndexController extends Controller
{
    public function indexAction()
    {
        dd(\App\Model\User::count());
        return \Library\Response::json(\Library\Response::HTTP_OK);
    }
}