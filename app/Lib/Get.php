<?php

namespace App\Lib;

use Illuminate\Support\Facades\Request;
use App\Providers\RouteServiceProvider;
class Get
{
    public static function home()
    {
        $prefix = Request::route()->getPrefix();
        if (strpos($prefix, 'admin') === 0) return RouteServiceProvider::ADMIN_HOME;
        if (strpos($prefix, 'owner') === 0) return RouteServiceProvider::OWNER_HOME;
        if ($prefix === '/') return RouteServiceProvider::HOME;
    }
    public static function routePrefix()
    {
        $prefix = Request::route()->getPrefix();
        if (strpos($prefix, 'admin') === 0) return 'admin';
        if (strpos($prefix, 'owner')  === 0) return 'owner';
        else return 'user';
    }

}

