<?php
namespace App\Http\Middleware;

use Library\Contracts\Middleware;
use Library\Response;

class CheckForMaintenanceMode implements Middleware
{
    public function handle($request)
    {
        if (env('APP_MAINTENANCE')) {
            return Response::json(Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return true;
    }
}
