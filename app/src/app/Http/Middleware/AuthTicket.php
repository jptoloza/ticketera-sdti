<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Helpers\SessionHelper;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthTicket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = SessionHelper::current();
        if (isset($session->id)) {
            if (!$session->unit_id || !$session->profile) {
                $uri = $request->getRequestUri();
                if ($uri != '/user/register' && $uri != '/user/register/update') {
                    return redirect()->route('user_register_form');
                }
            }
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
