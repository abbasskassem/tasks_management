<?php

namespace App\Core\Helpers;


use \Illuminate\Http\Request;
use Illuminate\Support\Str;

class  RouteHelper
{


    public static function isAdminRoute(Request $request): bool
    {
        $routeName = $request->route()
                             ->getName();


        if (Str::startsWith($routeName, 'admin.'))
        {
            return true;
        }

        return false;
    }

    public static function isPublicRoute(Request $request)
    {
        $routeName = $request->route()
                             ->getName();

        if (Str::startsWith($routeName, 'public.'))
        {
            return true;
        }

        return false;
    }

}
