<?php

namespace App\Http\Helpers;

use App\Models\Log;
use App\Models\LogTicket;
use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoggerHelper
{
    /**
     * 
     */
    public static function addRequestLog(Request $request)
    {
        RequestLog::create([
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'ip'        => $request->ip(),
            'headers'   => json_encode($request->headers->all()),
            'body'      => $request->all(),
        ]);
    }


    /**
     * 
     */
    public static function add(Request $request, $message)
    {
        if (!empty(Session::all()['id'])) {
            $user_id = Session::all()['id'];
        } else {
            $user_id = 0;
        }
        $log = Log::create([
            'url'       => $request->fullUrl(),
            'ip'        => $request->ip(),
            'user_id'   => $user_id,
            'register'  => $message
        ]);
        if (preg_match('/SQLSTATE/', $message)) {
            $message = "Error de base de datos. Código de registro : " . $log->id;
        }
        return $message;
    }



    /**
     * 
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $action
     * @param mixed $ticket_id
     * @param mixed $data
     * @return LogTicket
     */
    public static function ticket(Request $request, $action,$ticket_id,$data,$created_by)
    {
        $log = LogTicket::create([
            'ticket_id'     => $ticket_id,
            'data'          => json_encode($data->toArray()),
            'action'        => $action,
            'created_by'    => $created_by
        ]);
        return $log;
    }

}
