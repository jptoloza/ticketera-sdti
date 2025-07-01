<?php

namespace App\Http\Controllers;

use phpCAS;
use \Exception;
use App\Models\Unit;
use App\Models\User;
use App\Http\Helpers\Jquery;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\EmailNotification;
use App\Http\Helpers\UtilHelper;
use App\Models\TypeNotification;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


define('UC_CAS_VERSION', '2.0');
define('UC_CAS_HOSTNAME2', env('CAS_HOSTNAME'));
define('UC_CAS_PORT', 443);
define('UC_CAS_URI', '/cas');
define('UC_CAS_CLIENT_SERVICE', env('APP_URL'));
define('APP_ENV', env('APP_ENV'));


class LoginController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * Summary of __construct
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        // CAS Setup
        phpCAS::setLogger();
        phpCAS::client(UC_CAS_VERSION, UC_CAS_HOSTNAME2, UC_CAS_PORT, UC_CAS_URI, UC_CAS_CLIENT_SERVICE);
        if (APP_ENV != 'PROD') {
            phpCAS::setNoCasServerValidation();
        }
    }

    /**
     * 
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $data = Session::all();
        if (isset($data['login'])) {
            return redirect('/dashboard');
        }
        return view('index');
    }

    /**
     * 
     * Summary of loginCAS
     */
    public function loginCAS(Request $request)
    {
        try {
            if (!phpCAS::isAuthenticated()) {
                phpCAS::forceAuthentication();
            } else {
                $attributes = phpCAS::getAttributes();
                $userCas = phpCAS::getUser();
                $email      = phpCAS::getAttribute('mail');
                $rut        = phpCAS::getAttribute('carlicense');
                $first_name = phpCAS::getAttribute('nombre');
                $last_name  = phpCAS::getAttribute('apellidos');
                $name       = trim($first_name . ' ' . $last_name);
                $email      = $email != null ? $email : $userCas . '@uc.cl';
                $user = User::withTrashed()
                    ->where('login', '=', $userCas)
                    ->orWhere('email', '=', $email)
                    ->first();
                if (is_null($user)) {
                    $user = User::create([
                        'login' => $userCas,
                        'email' => $email,
                        'rut'   => $rut,
                        'name'  => $name,
                        'active' => true
                    ]);
                    LoggerHelper::add($request, 'CREATE USER: ' . $userCas);
                    $type = TypeNotification::where('type', 'ADMIN')->first();
                    Notification::create([
                        'type_notification_id'  => $type->id,
                        'register_id'           => $user->id,
                        'sent'                  => false,
                        'execute'               => false,
                        'contents'              => 'Nuevo Usuario: ' . $user->name
                    ]);
                } else {
                    if (!is_null($user->deleted_at) || $user->active == false) {
                        return view('errors.login');
                    }
                }
                $data = $user->toArray();
                $data['navbar_name'] = UtilHelper::navbarName($data['name']);
                Session($data);
                LoggerHelper::add($request, 'Login CAS OK: ' . $userCas);
                if (!$user->unit_id || !$user->profile) {
                    return redirect()->route('user_register_form');
                }
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            abort(401);
        }
    }

    /**
     * 
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        phpCAS::logout();
    }

    /**
     * 
     * Summary of registerFormCAS
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function registerFormCAS(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return view('administrator.users.edit', [
            'title'         => 'Usuarios',
            'user'          => $user,
            'units'         => Unit::where('active', true)->get(),
            'ajaxUpdate'    => Jquery::ajaxPost('actionForm', '/admin/users')
        ]);
    }




    /**
     * Summary of loginEmail
     * @param \Illuminate\Http\Request $request
     * @return bool|LoginController|mixed|string|\Illuminate\Http\JsonResponse
     */
    public function loginEmail(Request $request)
    {
        try {
            $rules = [
                'email' => ['required'],
            ];
            $messages = [
                'email' => 'Email no es válido.',
            ];
            $mainDomain = 'uc.cl';
            $nickname = strstr($request->input('email'), '@', true);
            $domain = substr(strrchr($request->input('email'), "@"), 1);
            if ($domain !== $mainDomain || !str_ends_with($domain, $mainDomain)) {
                return response()->json(
                    [
                        'success' => 'error',
                        'message' => '1No tiene permisos para ingresar a esta aplicación.',
                    ],
                    401,
                );
            }
            $user = User::where('email', '=', $request->input('email'))->first();
            if (is_null($user)) {
                $user = User::create([
                    'login' => $nickname,
                    'email' => $request->input('email'),
                    'rut'   => '1-9',
                    'name'  => 'NN',
                    'active' => true,
                    'code'  => UtilHelper::generateCode()
                ]);
                LoggerHelper::add($request, 'CREATE USER: ' . $request->input('email'));
                $type = TypeNotification::where('type', 'ADMIN')->first();
                Notification::create([
                    'type_notification_id'  => $type->id,
                    'register_id'           => $user->id,
                    'sent'                  => false,
                    'execute'               => false,
                    'contents'              => 'Nuevo Usuario: ' . $user->name
                ]);
            } 
            LoggerHelper::add($request, 'Login EMAIL OK: ' . $request->input('email'));
            Mail::to($request->input('email'))
                ->send(new EmailNotification('CODE', $user));

            return response()->json(
                [
                    'success' => 'ok',
                ],
                200
            );
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json(
                [
                    'success' => 'error',
                    'message' => $message,
                ],
                400,
            );
        }
    }



    /**
     * 
     *
     */
    public function loginEmailValidate(Request $request)
    {
        try {
            $rules = [
                'user' => ['required'],
                'code' => ['required'],
            ];
            $messages = [
                'user' => 'Usuario no es válido.',
                'code' => 'Código no es válido.',
            ];
            $user = User::where('email', '=', $request->input('user'))
                ->where('active', '=', true)
                ->whereNull('deleted_at')
                ->first();
            if (is_null($user)) {
                return response()->json(
                    [
                        'success'   => 'error',
                        'url'       => route('login_error')
                    ],
                    401,
                );
            }
            if ($user->code !== $request->input('code')) {
                return response()->json(
                    [
                        'success'   => 'error',
                        'message'   => 'Código no es válido.'
                    ],
                    400,
                );
            }
            $user->code = null;
            $user->save();
            LoggerHelper::add($request, 'LOGIN EMAIL USER: ' . $user->email);
            $data = $user->toArray();
            $data['navbar_name'] = UtilHelper::navbarName($data['name']);
            Session($data);
            if (!$user->unit_id || !$user->profile) {
                return response()->json(
                    [
                        'success'   => 'ok',
                        'url'       => route('user_register_form')
                    ],
                    200,
                );
            }
            return response()->json(
                [
                    'success'   => 'ok',
                    'url'       => '/'
                ],
                200,
            );
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json(
                [
                    'success' => 'error',
                    'message' => $message,
                ],
                400,
            );
        }
    }


    /**
     * 
     */
    public function loginError(Request $request)
    {
        return view('errors.401');
    }
}
