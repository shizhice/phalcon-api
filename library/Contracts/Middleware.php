<?php
namespace Library\Contracts;

interface Middleware
{
    /**
     * middleware handle
     * @param $request
     * @author shizhice<shizhice@gmail.com>
     * @return mixed
     */
    public function handle($request);
}