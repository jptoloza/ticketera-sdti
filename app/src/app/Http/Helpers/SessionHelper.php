<?php

namespace App\Http\Helpers;

use App\Models\UserRole;
use Illuminate\Support\Facades\Session;

class SessionHelper
{
    public static function current()
    {
        $userId = session('id');
        $userRoles = UserRole::where('user_id', $userId)
                        ->join('roles','roles.id', '=', 'user_roles.role_id')
                        ->pluck('roles.global_key','roles.id')->toArray();
        $data = Session::all();
        $data['roles'] = $userRoles;
        Session($data);
        return (object) [
            'id' => session('id'),
            'name' => session('name'),
            'email' => session('email'),
            'rut' => session('rut'),
            'unit_id' => session('unit_id'),
            'profile' => session('profile'),
            'roles' => session('roles'),
        ];
    }
}
