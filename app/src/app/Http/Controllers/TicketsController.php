<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Queue;
use App\Models\Status;
use App\Models\Priority;
use App\Models\QueueUser;
use Illuminate\Http\Request;
use App\Http\Helpers\RutRule;
use App\Http\Helpers\UtilHelper;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


class TicketsController extends Controller
{

    use ResponseTrait;


    /**
     * Summary of create
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $priorities = Priority::where('active', true)->orderBy('id')->get();
        $status = Status::where('active', true)->orderBy('id')->get();
        $queues = Queue::where('active', true)->orderBy('id')->get();
        return view('tickets.add', [
            'title' => 'Nuevo Ticket',
            'priorities' => $priorities,
            'status' => $status,
            'queues' => $queues
        ]);
    }


    /**
     * 
     * 
     */
    public function store(Request $request) {}


    /**
     * 
     * 
     */
    public function userSearch(Request $request)
    {
        $term = $request->input('term');
        $results = User::where('active', true)->where('name', 'ILIKE', '%' . $term . '%')
            ->take(10)
            ->get(['id', 'name']);
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'value' => $result->name,
                'id' => $result->id
            ];
        }
        return response()->json($data);
    }


    /**
     * 
     * 
     */
    public function agentQueue(Request $request)
    {
        $id = $request->input('queue_id');
        $agentsIS = QueueUser::where('queue_id', '=', $id)->get();
        $agents = [];
        foreach ($agentsIS as $agent) {
            $user = User::find($agent->user_id);
            $agents[] = [
                'id' => $user->id,
                'text' => $user->name
            ];
        }
        return response()->json($agents);
    }


    /**
     * 
     * 
     */
    public function addUser(Request $request)
    {
        $role_id = UtilHelper::globalKey('ROLE_AGENT');
        $roles = Session::all()['roles'];
        if (!in_array($role_id,$roles)) {
            abort(401);
        }
        try {
            $validated = $request->validate([
                'name'              => ['required'],
                'rut'               => ['unique:User,rut', new RutRule],
                'email'             => ['unique:User,email', 'required'],
                'login'             => ['unique:User,login', 'required'],
            ], [
                'name'              => 'Nombre no es válido.',
                'rut.unique'        => 'R.U.T. existe.',
                'email'             => 'Email no es válido.',
                'login.required'    => 'Usuario no es válido.',
                'login.unique'      => 'Nombre Usuario existe.',
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
            $user->active   = true;
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

}
