<?php

namespace App\Http\Helpers;

class UserSession
{
    public static function current()
    {
        return (object) [
            'id' => session('id'),
            'name' => session('name'),
            'email' => session('email'),
            'rut' => session('rut'),
            'roles' => session('roles'),
        ];
    }
}
