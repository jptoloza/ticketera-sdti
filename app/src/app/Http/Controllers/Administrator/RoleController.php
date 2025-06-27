<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Helpers\Jquery;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('administrator.roles.index', [
            'title'   => 'Roles',
            'ajaxGet' => Jquery::ajaxGet('url', '/admin/roles')
        ]);
    }

    /**
     * 
     * Summary of get
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $roles = Role::select('id', 'role', 'global_key', 'active')->orderBy('id')->get();
        $data = [];
        foreach ($roles as $role) {
            $link   = '<a href="' . route('admin_roles_editForm', ['id' => $role->id]) . '" title="Editar"><span class="uc-icon">edit</span></a> 
                <a href="' . route('admin_roles_delete', ['id' => $role->id]) . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>  
                <a href="' . route('admin_roles_users', ['id' => $role->id]) . '"title="Añadir Usuario "><span class="uc-icon">person_add</span></a>';
            $data[] = [
                $link,
                $role->active ? 'Sí' : 'No',
                $role->global_key,
                $role->role,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     *
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('administrator.roles.add', [
            'title'   => 'Roles',
            'ajaxAdd' => Jquery::ajaxPost('actionForm', '/admin/roles')
        ]);
    }

    /**
     *
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|RoleController|string|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'              => ['required'],
                'global_key'        => ['required'],
                'active'            => 'required',
            ], [
                'name'              => 'Nombre no es válido.',
                'global_key'        => 'Global Key no es válido.',
                'active'            => 'Activo no es válido.',
            ]);
            $name = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $global_key = mb_convert_case($request->input('global_key'), MB_CASE_UPPER);
            $role = Role::where('role', $name)
                ->where('global_key', $global_key)->first();
            if ($role) {
                throw new Exception('Rol registrado anteriormente.');
            }
            $role = new Role();
            $role->role         = $name;
            $role->global_key   = $global_key;
            $role->active       = (int) $request->input('active') == 1 ? true : false;
            $role->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'ADD|OK|ROL:' . $role->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $role
            ], 201);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     *
     * Summary of edit
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            abort(404);
        }
        return view('administrator.roles.edit', [
            'title'       => 'Roles',
            'role'        => $role,
            'ajaxUpdate'  => Jquery::ajaxPost('actionForm', '/admin/roles')
        ]);
    }

    /**
     *
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|RoleController|string|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id'        => ['required'],
                'name'      => ['required'],
                'global_key'=> ['required'],
                'active'    => 'required',
            ], [
                'id'        => 'ID no es válido',
                'name'      => 'Nombre no es válido.',
                'global_key'=> 'Global Key no es válido.',
                'active'    => 'Usuario Activo no es válido.',
            ]);
            $name     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $global_key = mb_convert_case($request->input('global_key'), MB_CASE_UPPER);
            $role = Role::find($request->input('id'));
            if (!$role) {
                throw new Exception('Rol no registrado.');
            }
            $roles = Role::where('role', $name)->orWhere('global_key',$global_key);
            if ($roles->count() > 0) {
                foreach ($roles->get() as $uurole) {
                    $uurole = (object)$uurole;
                    if ($uurole->id != $role->id) {
                        throw new Exception('Rol registrado anteriormente.');
                    }
                }
            }
            $role->role     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $role->global_key = mb_convert_case($request->input('global_key'), MB_CASE_UPPER);
            $role->active   = (int) $request->input('active') == 1 ? true : false;
            $role->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|ROL:' . $role->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $role
            ], 201);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     *
     * Summary of destroy
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @throws \Exception
     * @return bool|mixed|RoleController|string|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id = null)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                throw new Exception('Rol no existe.');
            }
            $role->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|ROL:' . $id . '|' . json_encode($role->toArray()));
            return response()->json([
                'success'   => 'ok',
                'data'      => $role
            ], 200);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request,  $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     *
     * Summary of users
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View
     */
    public function users(Request $request, $id = null)
    {
        $role = Role::find($id);
        if (!$role) {
            abort(404);
        }
        $userRoles = UserRole::join('users AS A', 'user_roles.user_id', '=', 'A.id')
            ->join('roles AS B', 'user_roles.role_id', '=', 'B.id')
            ->select('user_roles.id', 'A.id as user_id', 'A.rut', 'A.name', 'A.email', 'B.role')
            ->where('user_roles.role_id', '=', $id)
            ->where('A.active', '=', true)
            ->where('B.active', '=', true)
            ->orderBy('A.name', 'asc')
            ->get();
        $data = [];
        foreach ($userRoles as $value) {
            $_data = UtilHelper::ucTexto($value->name) . ' ( ' . $value->email . ' / ' . $value->rut . ' )';
            $data[$value->id] = $_data;
        }
        $dataUsers = [];
        $users = User::where('active', '=', true)
            ->get();
        foreach ($users as $user) {
            $dataUsers[$user->id] = UtilHelper::ucTexto($user->name) . ' ( ' . $user->email . ' / ' . $user->rut . ' )';
        }
        return view('administrator.roles.add_users', [
            'title'     => 'Roles',
            'role'      => $role,
            'data'      => $data,
            'users'     => $dataUsers,
            'ajaxAdd'   => Jquery::ajaxPost('actionForm', route('admin_roles_users', $role->id)),
            'ajaxGet'   => Jquery::ajaxGet('url', route('admin_roles_users', $role->id))
        ]);
    }

    /**
     *
     * Summary of addUser
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|RoleController|string|\Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_id' => ['required'],
                'user_id' => ['required'],
            ], [
                'role_id' => 'Role ID no es valido',
                'user_id' => 'Usuario no es valido.',
            ]);
            $userRole = UserRole::where('user_id', $request->input('user_id'))
                ->where('role_id',  $request->input('role_id'))->first();
            if ($userRole) {
                throw new Exception('Usuario registrado anteriormente.');
            }
            $userRole = UserRole::withTrashed()->where('user_id', '=',$request->input('user_id'))
                ->where('role_id',  '=',$request->input('role_id'))->first();
            if ($userRole) {
                $userRole->restore();
            } else {
                $userRole = new UserRole();
                $userRole->role_id = $request->input('role_id');
                $userRole->user_id = $request->input('user_id');
                $userRole->save();
            }
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'ADD|OK|USER_ROLE:' . $userRole->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $userRole
            ], 201);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     *
     * Summary of deleteUser
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @throws \Exception
     * @return bool|mixed|RoleController|string|\Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, $id = 0)
    {
        try {
            $userRole = UserRole::find($id);
            if (!$userRole) {
                throw new Exception('Usuario no existe.');
            }
            $userRole->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|USER_ROLE:' . $id);

            return response()->json([
                'success'   => 'ok',
                'data'      => $userRole
            ], 200);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }
}
