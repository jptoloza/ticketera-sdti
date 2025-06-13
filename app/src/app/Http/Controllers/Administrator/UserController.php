<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Jquery;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator.users.index', [
          'title'   => 'Usuarios',
          'ajaxGet' => Jquery::ajaxGet('url', '/admin/users')
        ]);
    }

    public function getUsers()
    {
        $users = User::select(
            'users.id',  
            'users.name',
            'users.rut',
            'users.login',
            'users.email',
            'users.activate',
        )->get();

        $data = [];
        foreach ($users as $user) {
            $link   = '
                <a href="/admin/users/edit/' . $user->id . '" title="Editar"><span class="uc-icon">edit</span></a>&nbsp;&nbsp;
                <a href="/admin/users/delete/' . $user->id . '" class="btnDelete" title="Eliminar"><i class="uc-icon">delete</i></a>';
            $data[] = [
                $link,
                $user->activate == 1 ? 'Sí' : 'No',
                $user->login,
                $user->name,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id = 0)
    {
        // Nada aun 
    }
}
