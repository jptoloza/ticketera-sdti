<?php

namespace App\Http\Helpers;

use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoggerHelper
{
    /**
     * 
     */
    public static function add(Request $request, $message)
    {
        if (!empty(Session::get('user'))) {
            $user_id = Session::get('user')->id;
            $user_login = Session::get('user')->login;
        } else {
            $user_id = 0;
            $user_login = 0;
        }

        RequestLog::create([
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'ip'        => $request->ip(),
            'headers'   => json_encode($request->headers->all()),
            'body'      => $message,
        ]);
    }
}
