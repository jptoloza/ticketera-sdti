<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\Unit;
use App\Models\User;
use App\Http\Helpers\Jquery;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Helpers\RutRule;
use App\Http\Helpers\UtilHelper;
use App\Models\TypeNotification;
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
     * 
     * Summary of registerForm
     * @return \Illuminate\Contracts\View\View
     */
    public function registerForm()
    {
        $user = User::find(Session::all()['id']);
        if (!$user) {
            abort(404);
        }
        return view('user.register', [
            'title'         => 'Usuario',
            'user'          => $user,
            'units'         => Unit::where('active', true)->orderBy('unit')->get(),
            'ajaxUpdate'    => Jquery::ajaxPost('actionForm', '/')
        ]);
    }

    /**
     * 
     * Summary of updateRegister
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|string|UserController|\Illuminate\Http\JsonResponse
     */
    public function updateRegister(Request $request)
    {
        try {
            $rules = [
                'id'                => ['required'],
                'name'              => ['required'],
                'rut'               => [new RutRule],
                'email'             => ['required'],
                'login'             => ['required'],
                'unit'              => ['required'],
                'profile'           => ['required', 'array'],
                'profile.*'         => 'in:Académico,Estudiante,Funcionario,Otro',
            ];
            $messages = [
                'id'                => 'ID no es válido.',
                'name'              => 'Nombre no es válido.',
                'rut.unique'        => 'R.U.T. existe.',
                'email'             => 'Email no es válido.',
                'login.required'    => 'Usuario no es válido.',
                'login.unique'      => 'Nombre Usuario existe.',
                'unit'              => 'Unidad no es válida.',
                'profile.required'  => 'Perfil no es válido.',
                'profile.array'     => 'Perfil no seleccionado.',
            ];
            if ($request->input('unit') == 'other') {
                $rules['unit_code']     = ['required'];
                $rules['unit_name']     = ['required'];
                $message['unit_code']   = 'Código de Unidad no válido';
                $message['unit_name']   = 'Nombre de Unidad no válido';
            }
            $validated = $request->validate($rules, $messages);
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
            if ($request->input('unit') == 'other') {
                $unit           = new Unit();
                $unit->code     = $request->input('unit_code');
                $unit->unit     = $request->input('unit_name');
                $unit->active   = true;
                $unit->validate = false;
                $unit->save();
                $user->unit_id = $unit->id;
                $type = TypeNotification::where('type', 'ADMIN')->first();
                Notification::create([
                    'type_notification_id'  => $type->id,
                    'register_id'           => $user->id,
                    'sent'                  => false,
                    'execute'               => false,
                    'contents'              => 'Nuevo Usuario: ' . $user->name
                ]);
            } else {
                $user->unit_id = $request->input('unit');
            }
            $profile_options    = $request->input('profile', []);
            $user->profile      = implode(",", $profile_options);
            $user->save();
            $data = $user->toArray();
            $data['navbar_name'] = UtilHelper::navbarName($data['name']);
            Session($data);
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|USERREGISTER:' . $user->id);
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
     *
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = User::find(Session::all()['id']);
        if (!$user) {
            abort(404);
        }
        return view('user.profile', [
            'title'         => 'Usuario',
            'user'          => $user,
            'units'         => Unit::where('active', true)->orderBy('unit')->get(),
            'ajaxUpdate'    => Jquery::ajaxPost('actionForm', '/user')
        ]);
    }

    /**
     *
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|string|UserController|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        try {
            $rules = [
                'name'              => ['required'],
                'rut'               => [new RutRule],
                'email'             => ['required'],
                'login'             => ['required'],
                'unit'              => ['required'],
                'profile'           => ['required', 'array'],
                'profile.*'         => 'in:Académico,Estudiante,Funcionario,Otro',
            ];
            $messages = [
                'name'              => 'Nombre no es válido.',
                'rut.unique'        => 'R.U.T. existe.',
                'email'             => 'Email no es válido.',
                'login.required'    => 'Usuario no es válido.',
                'login.unique'      => 'Nombre Usuario existe.',
                'unit'              => 'Unidad no es válida.',
                'profile.required'  => 'Perfil no es válido.',
                'profile.array'     => 'Perfil no seleccionado.',
            ];

            $validated = $request->validate($rules, $messages);
            $rut = preg_replace("/\./", "", $request->input('rut'));
            $user = User::find(Session::all()['id']);
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
            $user->email        = mb_convert_case($request->input('email'), MB_CASE_LOWER);
            $user->login        = mb_convert_case($request->input('login'), MB_CASE_LOWER);
            $user->rut          = $rut;
            $user->name         = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $user->unit_id      = $request->input('unit');
            $profile_options    = $request->input('profile', []);
            $user->profile      = implode(",", $profile_options);
            $user->save();
            $data = $user->toArray();
            $data['navbar_name'] = UtilHelper::navbarName($data['name']);
            Session($data);
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|USERUSER:' . $user->id);
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
}
