<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleName = null): Response
    {
        $data = Session::all();
        $role_id = UtilHelper::globalKey($roleName);
        $user_id = $data['id'];
        $userRole = UserRole::where('user_id', $user_id)
                    ->where('role_id', $role_id)->first();
        if (!empty($userRole)) {
            return $next($request);    
        } else {
            return redirect('/');
        }
    }
}
