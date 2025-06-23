<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use App\Models\Unit;
use App\Models\User;
use App\Http\Helpers\Jquery;
use Illuminate\Http\Request;
use App\Http\Helpers\RutRule;
use App\Http\Helpers\UtilHelper;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Helpers\SessionHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ResponseTrait;
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

    /**
     * 
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $users = User::leftJoin('units','units.id','=','users.unit_id')
                    ->select('users.id','users.name','users.rut','users.login','users.email','users.unit_id','units.unit','users.profile','users.active')->orderBy('id')->get();
        $data = [];
        foreach ($users as $user) {
            $link   = '<a href="' . route('admin_users_editForm', $user->id) . '" title="Editar"><span class="uc-icon">edit</span></a> <a href="' . route('admin_users_delete', $user->id) . '" class="btnDelete" title="Eliminar"><i class="uc-icon">delete</i></a>';
            $array_profile = explode(",", $user->profile);
            $data[] = [
                $link,
                $user->active ? 'Sí' : 'No',
                $user->email,
                $user->login,
                $user->rut,
                UtilHelper::ucTexto($user->name),
                UtilHelper::ucTexto($user->unit),
                implode(", ", $array_profile)
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.users.add', [
            'title'   => 'Usuarios',
            'ajaxAdd' => Jquery::ajaxPost('actionForm', '/admin/users')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'              => ['required'],
                'rut'               => ['unique:App\Models\User,rut', new RutRule],
                'email'             => ['unique:App\Models\User,email', 'required'],
                'login'             => ['unique:App\Models\User,login', 'required'],
                'active'            => 'required',
            ], [
                'name'              => 'Nombre no es válido.',
                'rut.unique'        => 'R.U.T. existe.',
                'email'             => 'Email no es válido.',
                'login.required'    => 'Usuario no es válido.',
                'login.unique'      => 'Nombre Usuario existe.',
                'active'            => 'Usuario Activo no es válido.',
            ]);

            $rut = preg_replace("/\./", "", $request->input('rut'));
            $user = User::where('email', '=', $request->input('email'))
                ->orWhere('login', '=', $request->input('login'))
                ->orWhere('rut', '=', $rut)
                ->first();
            if ($user) {
                throw new Exception('Usuario registrado anteriormente.');
            }
            $user = new User();
            $user->email    = mb_convert_case($request->input('email'), MB_CASE_LOWER);
            $user->login    = mb_convert_case($request->input('login'), MB_CASE_LOWER);
            $user->rut      = $rut;
            $user->name     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $user->active   = (int) $request->input('active') == 1 ? true : false;
            $user->save();

            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'ADD|OK|USER:' . $user->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $user
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return view('administrator.users.edit', [
            'title'     => 'Usuarios',
            'user'      => $user,
            'units'     => Unit::where('active',true)->get(),
            'ajaxUpdate'=> Jquery::ajaxPost('actionForm', '/admin/users')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            $validated = $request->validate([
                'id'                => ['required'],
                'name'              => ['required'],
                'rut'               => [new RutRule],
                'email'             => ['required'],
                'login'             => ['required'],
                'unit'              => ['required'],
                'profile'           => ['required','array'],
                'profile.*'         => 'in:Académico,Estudiante,Funcionario,Otro',
                'active'            => 'required',
            ], [
                'id'                => 'ID no es válido.',
                'name'              => 'Nombre no es válido.',
                'rut.unique'        => 'R.U.T. existe.',
                'email'             => 'Email no es válido.',
                'login.required'    => 'Usuario no es válido.',
                'login.unique'      => 'Nombre Usuario existe.',
                'unit'              => 'Unidad no es válida.',
                'profile.required'  => 'Perfil no es válido.',
                'profile.array'     => 'Perfil no seleccionado.',
                'active'            => 'Usuario Activo no es válido.',
            ]);

            $rut = preg_replace("/\./", "", $request->input('rut'));
            $user = User::find($request->input('id'));
            if (!$user) {
                throw new Exception('Usuario no registrado.');
            }
            $users = User::where('email', '=', $request->input('email'))
                ->orWhere('login', '=', $request->input('login'))
                ->orWhere('rut', '=', $rut);

            if ($users->count() > 0) {
                foreach ($users->get() as $uuser) {
                    $uuser = (object)$uuser;
                    if ($uuser->id != $user->id) {
                        throw new Exception('Usuario registrado anteriormente.');
                    }
                }
            }
            $user->email    = mb_convert_case($request->input('email'), MB_CASE_LOWER);
            $user->login    = mb_convert_case($request->input('login'), MB_CASE_LOWER);
            $user->rut      = $rut;
            $user->name     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $user->unit_id  = $request->input('unit');
            $profile_options= $request->input('profile', []);
            $user->profile  = implode(",", $profile_options);
            $user->active   = (int) $request->input('active') == 1 ? true : false;
            $user->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|USER:' . $user->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $user
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id = 0)
    {
        try {
            $userSessionId = SessionHelper::current()->id;
            if ($userSessionId == $id) {
                throw new Exception('No puede borrar el usuario.');                
            }
            $user = User::find($id);
            if (!$user) {
                throw new Exception('Usuario no existe.');
            }
            $user->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|USER:' . $id . '|' . json_encode($user->toArray()));
            return response()->json([
                'success'   => 'ok',
                'data'      => $user
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
}
