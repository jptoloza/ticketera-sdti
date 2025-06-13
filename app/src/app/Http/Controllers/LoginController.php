<?php

namespace App\Http\Controllers;

use phpCAS;
use \Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Helpers\UtilHelper;
use Illuminate\Support\Facades\Session;
use App\Models\UserRole;

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
     * 
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
     *
     */
    public function loginCAS(Request $request)
    {
        try {
            if (!phpCAS::isAuthenticated()) {
                phpCAS::forceAuthentication();
            } else {
                $attributes = phpCAS::getAttributes();
                $userCas = phpCAS::getUser();
                $user = User::where('login', '=', $userCas)
                    ->first();
                if ($user == NULL) {
                    $email = phpCAS::getAttribute('mail');
                    $rut = phpCAS::getAttribute('carlicense');
                    $first_name = phpCAS::getAttribute('nombre');
                    $last_name = phpCAS::getAttribute('apellidos');
                    $name = trim($first_name . ' ' . $last_name);
                    $user = User::create([
                        'login' => $userCas,
                        'email' => $email != null ? $email : $userCas . '@uc.cl',
                        'rut'   => $rut,
                        'name'  => $name,
                    ]);
                    LoggerHelper::add($request, 'CREATE USER: ' . $userCas);
                }
                $data = $user->toArray();
                $data['navbar_name'] = UtilHelper::navbarName($data['name']);
                $userRoles = UserRole::where('user_id', $user->id)->select('role_id')->get();
                $roles = [];
                foreach($userRoles as $userRol) {
                    $roles[] = $userRol->role_id;
                }
                $data['roles'] = $roles;
                Session($data); 
                LoggerHelper::add($request, 'Login CAS OK: ' . $userCas);
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            dd($e);
            abort(401);
        }
    }

    /**
     *
     *
     */
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        phpCAS::logout();
    }
}
