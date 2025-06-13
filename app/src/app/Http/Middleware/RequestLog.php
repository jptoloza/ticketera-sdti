<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\RequestLog as Log;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       Log::create([
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'ip'        => $request->ip(),
            'headers'   => json_encode($request->headers->all()),
            'body'      => json_encode($request->all()),
        ]);

        return $next($request);    
    }
}
