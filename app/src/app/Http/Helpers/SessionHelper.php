<?php

namespace App\Http\Helpers;

use App\Models\UserRole;
use Illuminate\Support\Facades\Session;

class SessionHelper
{
    public static function current()
    {
        $userId = session('id');
        $userRoles = UserRole::where('user_id', $userId)->select('role_id')->get();
        $roles = [];
        foreach ($userRoles as $userRol) {
            $roles[] = $userRol->role_id;
        }
        $data = Session::all();
        $data['roles'] = $roles;
        Session($data);
        return (object) [
            'id' => session('id'),
            'name' => session('name'),
            'email' => session('email'),
            'rut' => session('rut'),
            'roles' => session('roles'),
        ];
    }
}
