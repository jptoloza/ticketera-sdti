<?php

namespace App\Http\Controllers;

use phpCAS;
use \Exception;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Helpers\Jquery;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Models\TypeNotification;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

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
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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
            dd($e->getMessage());
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
}
