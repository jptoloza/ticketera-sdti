<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use App\Models\User;
use App\Models\Queue;
use App\Models\QueueUser;
use App\Http\Helpers\Jquery;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class QueuesController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('administrator.queues.index', [
            'title'   => 'Equipos',
            'ajaxGet' => Jquery::ajaxGet('url', '/admin/queues')
        ]);
    }

    /**
     * 
     * Summary of get
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $queues = Queue::select('id', 'queue', 'active')->orderBy('id')->get();
        $data = [];
        foreach ($queues as $queue) {
            $link   = '<a href="' . route('admin_queues_editForm', ['id' => $queue->id]) . '" title="Editar"><span class="uc-icon">edit</span></a> 
                <a href="' . route('admin_queues_delete', ['id' => $queue->id]) . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>  
                <a href="' . route('admin_queues_users', ['id' => $queue->id]) . '"title="Añadir Usuario "><span class="uc-icon">person_add</span></a>';
            $data[] = [
                $link,
                $queue->active ? 'Sí' : 'No',
                $queue->queue,
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
        return view('administrator.queues.add', [
            'title'   => 'Equipos',
            'ajaxAdd' => Jquery::ajaxPost('actionForm', '/admin/queues')
        ]);
    }

    /**
     * 
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|QueuesController|string|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'      => ['required'],
                'active'    => 'required',
            ], [
                'name'      => 'Nombre no es válido.',
                'active'    => 'Usuario Activo no es válido.',
            ]);
            $queue = Queue::where('queue', '=', $request->input('name'))->first();
            if ($queue) {
                throw new Exception('Rol registrado anteriormente.');
            }
            $queue = Queue::withTrashed()->where('queue', '=', $request->input('name'))->first();
            if ($queue) {
                $queue->restore();
            } else {
                $queue = new Queue();
                $queue->queue    = mb_convert_case($request->input('name'), MB_CASE_UPPER);
                $queue->active   = (int) $request->input('active') == 1 ? true : false;
                $queue->save();
            }
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'ADD|OK|QUEUE:' . $queue->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $queue
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
        $queue = Queue::find($id);
        if (!$queue) {
            abort(404);
        }
        return view('administrator.queues.edit', [
            'title'     => 'Equipos',
            'queue'     => $queue,
            'ajaxUpdate'=> Jquery::ajaxPost('actionForm', '/admin/queues')
        ]);
    }

    /**
     * 
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|QueuesController|string|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id'       => ['required'],
                'name'     => ['required'],
                'active'   => 'required',
            ], [
                'id'       => 'ID no es válido',
                'name'     => 'Nombre no es válido.',
                'active'   => 'Usuario Activo no es válido.',
            ]);
            $queue = Queue::find($request->input('id'));
            if (!$queue) {
                throw new Exception('Rol no registrado.');
            }
            $queues = Queue::where('queue', '=', $request->input('name'));
            if ($queues->count() > 0) {
                foreach ($queues->get() as $uuqueue) {
                    $uuqueue = (object)$uuqueue;
                    if ($uuqueue->id != $queue->id) {
                        throw new Exception('Cola registrada anteriormente.');
                    }
                }
            }
            $queue->queue    = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $queue->active   = (int) $request->input('active') == 1 ? true : false;
            $queue->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|QUEUE:' . $queue->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $queue
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
     * @return bool|mixed|QueuesController|string|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id = null)
    {
        try {
            $queue = Queue::find($id);
            if (!$queue) {
                throw new Exception('Cola no existe.');
            }
            $queue->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|QUEUE:' . $id . '|' . json_encode($queue->toArray()));
            return response()->json([
                'success'   => 'ok',
                'data'      => $queue
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
        $queue = Queue::find($id);
        if (!$queue) {
            abort(404);
        }
        $userQueues = QueueUser::join('users AS A', 'queue_users.user_id', '=', 'A.id')
            ->join('queues AS B', 'queue_users.queue_id', '=', 'B.id')
            ->select('queue_users.id', 'A.id as user_id', 'A.rut', 'A.name', 'A.email', 'B.queue')
            ->where('queue_users.queue_id', '=', $id)
            ->where('A.active', '=', true)
            ->where('B.active', '=', true)
            ->orderBy('A.name', 'asc')
            ->get();

        $data = [];
        foreach ($userQueues as $value) {
            $_data = UtilHelper::ucTexto($value->name) . ' ( ' . $value->email . ' / ' . $value->rut . ' )';
            $data[$value->id] = $_data;
        }
        $dataUsers = [];
        $assignedUserIds = QueueUser::where('queue_id', $queue->id)
            ->pluck('user_id')
            ->toArray();
        $users = User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('users.active', true)
            ->where(function ($query) {
                $adminRoleId = UtilHelper::globalKey('ROLE_ADMINISTRATOR');
                $managerRoleId = UtilHelper::globalKey('ROLE_MANAGER');
                $agentRoleId = UtilHelper::globalKey('ROLE_AGENT');
                $query->where('user_roles.role_id', '=', $agentRoleId)
                    ->orWhere('user_roles.role_id', '=', $adminRoleId)
                    ->orWhere('user_roles.role_id', '=', $managerRoleId);
            })
            ->whereNotIn('users.id', $assignedUserIds)
            ->select('users.*')
            ->orderBy('users.name', 'asc')
            ->get();
        foreach ($users as $user) {
            $dataUsers[$user->id] = UtilHelper::ucTexto($user->name) . ' ( ' . $user->email . ' / ' . $user->rut . ' )';
        }
        return view('administrator.queues.add_users', [
            'title'     => 'Equipos',
            'queue'      => $queue,
            'data'      => $data,
            'users'     => $dataUsers,
            'ajaxAdd'   => Jquery::ajaxPost('actionForm', route('admin_queues_users', $queue->id)),
            'ajaxGet'   => Jquery::ajaxGet('url', route('admin_queues_users', $queue->id))
        ]);
    }

    /**
     * 
     * Summary of addUser
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|QueuesController|string|\Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'queue_id'  => ['required'],
                'user_id'   => ['required'],
            ], [
                'queue_id'  => 'Cola ID no es valido',
                'user_id'   => 'Usuario no es valido.',
            ]);
            $userQueue = QueueUser::where('user_id', $request->input('user_id'))
                ->where('queue_id',  $request->input('queue_id'))->first();
            if ($userQueue) {
                throw new Exception('Usuario registrado anteriormente.');
            }
            $userQueue = QueueUser::withTrashed()->where('user_id', $request->input('user_id'))
                ->where('queue_id',  $request->input('queue_id'))->first();
            if ($userQueue) {
                $userQueue->restore();
            } else {
                $userQueue              = new QueueUser();
                $userQueue->queue_id    = $request->input('queue_id');
                $userQueue->user_id     = $request->input('user_id');
                $userQueue->save();
            }
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'ADD|OK|USER_QUEUE:' . $userQueue->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $userQueue
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
     * @return bool|mixed|QueuesController|string|\Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, $id = 0)
    {
        try {
            $userQueue = QueueUser::find($id);
            if (!$userQueue) {
                throw new Exception('Usuario no existe.');
            }
            $userQueue->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|USER_QUEUE:' . $id);

            return response()->json([
                'success'   => 'ok',
                'data'      => $userQueue
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
