<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Jquery;
use App\Http\Helpers\Util;
use App\Models\Role;


class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator.roles.index', [
          'title'   => 'Roles',
          'ajaxGet' => Jquery::ajaxGet('url', '/admin/roles')
        ]);
    }

    public function get()
    {
        $roles = Role::select(
            'roles.id',
            'roles.role',
            'roles.active',
        )->get();

        $data = [];

        foreach ($roles as $role) {
            $link   = '
                <a href="/admin/roles/edit/' . $role->id . '" title="Editar"><span class="uc-icon">edit</span></a>&nbsp;&nbsp;
                <a href="/admin/roles/delete/' . $role->id . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>&nbsp;&nbsp; 
                <a href="/admin/roles/userAdd/' . $role->id . '"title="Añadir Usuario "><span class="uc-icon">person_add</span></a>';
            $data[] = [
                $link,
                $role->active == 1 ? 'Sí' : 'No',
                $role->role,
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
    public function destroy(string $id)
    {
        //
    }
}
