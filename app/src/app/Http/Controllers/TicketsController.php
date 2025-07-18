<?php

namespace App\Http\Controllers;

use Exception;
use HTMLPurifier;
use App\Models\User;
use App\Models\Queue;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Priority;
use HTMLPurifier_Config;
use App\Models\LogTicket;
use App\Models\QueueUser;
use Illuminate\Support\Str;
use App\Http\Helpers\Jquery;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Helpers\RutRule;
use App\Models\TicketMessage;
use App\Http\Helpers\UtilHelper;
use App\Models\TypeNotification;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TicketsController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Session::all()['id'])
            ->join('status', 'status.id', '=', 'tickets.status_id')
            ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->join('queues', 'queues.id', '=', 'tickets.queue_id')
            ->orderByDesc('id')
            ->select(
                'tickets.id',
                'tickets.subject',
                'tickets.created_at',
                'tickets.updated_at',
                'status.status',
                'status.id as status_id',
                'status.global_key',
                'queues.queue',
                'users.name',
                'users.email'
            )
            ->get();
        return view('tickets.index', [
            'title' => 'Tickets',
            'tickets' => $tickets,
        ]);
    }

    /**
     * 
     * Summary of indexNoAssignedByQueue
     * @param mixed $queueId
     * @return \Illuminate\Contracts\View\View
     */
    public function indexNoAssignedByQueue($queueId)
    {
        $user = User::find(session('id'));
        $hasAccess = $user->queues->contains('id', $queueId);
        if (!$hasAccess) {
            abort(403, 'No tienes acceso a esta cola.');
        }
        $tickets = Ticket::whereNull('assigned_agent')
            ->where('queue_id', $queueId)
            ->join('status', 'status.id', '=', 'tickets.status_id')
            ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->join('queues', 'queues.id', '=', 'tickets.queue_id')
            ->orderByDesc('tickets.id')
            ->select(
                'tickets.id',
                'tickets.subject',
                'tickets.created_at',
                'tickets.updated_at',
                'status.status',
                'status.id as status_id',
                'status.global_key',
                'queues.queue',
                'users.name',
                'users.email'
            )
            ->get();
        $queue = Queue::find($queueId);
        return view('tickets.indexUnassigned', [
            'title'     => $queue->queue . ': Tickets no asignados',
            'tickets'   => $tickets,
            'queue'     => $queue
        ]);
    }

    /**
     * 
     * Summary of indexAssigned
     * @return \Illuminate\Contracts\View\View
     */
    public function indexAssigned()
    {
        $userId = session('id');
        $tickets = Ticket::where('assigned_agent', $userId)
            ->join('status', 'status.id', '=', 'tickets.status_id')
            ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->join('queues', 'queues.id', '=', 'tickets.queue_id')
            ->orderByDesc('tickets.id')
            ->select(
                'tickets.id',
                'tickets.subject',
                'tickets.created_at',
                'tickets.updated_at',
                'status.status',
                'status.id as status_id',
                'status.global_key',
                'queues.queue',
                'users.name',
                'users.email'
            )
            ->get();
        return view('tickets.indexAssigned', [
            'title' => 'Mis tickets asignados',
            'tickets' => $tickets,
        ]);
    }

    /**
     * 
     * Summary of indexByQueue
     * @param mixed $queueId
     * @return \Illuminate\Contracts\View\View
     */
    public function indexByQueue($queueId)
    {
        $userId = session('id');

        $user = User::find($userId);
        if (!$user->queues->contains('id', $queueId)) {
            abort(403, 'No tienes acceso a esta cola.');
        }
        $tickets = Ticket::where('queue_id', $queueId)
            ->join('status', 'status.id', '=', 'tickets.status_id')
            ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->join('queues', 'queues.id', '=', 'tickets.queue_id')
            ->orderByDesc('tickets.id')
            ->select(
                'tickets.id',
                'tickets.subject',
                'tickets.created_at',
                'tickets.updated_at',
                'status.status',
                'status.id as status_id',
                'status.global_key',
                'queues.queue',
                'users.name',
                'users.email'
            )
            ->get();
        $queue = Queue::find($queueId);
        return view('tickets.indexByQueue', [
            'title'     => $queue->queue . ': Todos los tickets',
            'tickets'   => $tickets,
            'queue'     => $queue
        ]);
    }

    /**
     * 
     * Summary of view
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View
     */
    public function view(Request $request, $id = null)
    {
        if (
            in_array('ROLE_ADMINISTRATOR', session('roles')) ||
            in_array('ROLE_AGENT', session('roles')) ||
            in_array('ROLE_MANAGER', session('roles'))
        ) {
            $ticket = Ticket::where('tickets.id', $id)
                ->join('status', 'tickets.status_id', '=', 'status.id')
                ->select('tickets.*', 'status.status', 'status.global_key')
                ->first();
        } else {
            $ticket = Ticket::where('user_id', Session::all()['id'])
                ->where('tickets.id', $id)
                ->join('status', 'tickets.status_id', '=', 'status.id')
                ->select('tickets.*', 'status.status', 'status.global_key')
                ->first();
        }
        if (empty($ticket)) {
            abort(404);
        }
        $requesterBy    = User::find($ticket->user_id);
        $createdBy      = User::find($ticket->created_by);
        $priorities     = Priority::where('active', true)->orderBy('id')->get();
        $status         = Status::where('active', true)->orderBy('id')->get();
        $queues         = Queue::where('active', true)->orderBy('id')->get();
        $logs           = LogTicket::where('ticket_id', $ticket->id)->orderByDesc('id')->get();
        $messages       = TicketMessage::where('ticket_id', $ticket->id)->join('users', 'users.id', '=', 'ticket_messages.created_by')->select('ticket_messages.*', 'users.name')->orderBy('id')->get();
        $id             = $request->input('queue_id');
        $agentsIS       = QueueUser::where('queue_id', '=', $ticket->queue_id)->get();
        $agents         = [];
        foreach ($agentsIS as $agent) {
            $user = User::find($agent->user_id);
            $agents[] = $user->toArray();
        }
        return view('tickets.view', [
            'title' => 'Ticket',
            'ticket' => $ticket,
            'files' => json_decode($ticket->files),
            'agents' => $agents,
            'priorities' => $priorities,
            'status' => $status,
            'queues' => $queues,
            'requesterBy' => $requesterBy,
            'createdBy' => $createdBy,
            'messages' => $messages,
            'logs' => $logs,
        ]);
    }

    /**
     * 
     * Summary of create
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $priorities = Priority::where('active', true)->orderBy('id')->get();
        $status     = Status::where('active', true)->orderBy('id')->get();
        $queues     = Queue::where('active', true)->orderBy('id')->get();
        return view('tickets.add', [
            'title' => 'Nuevo Ticket',
            'priorities' => $priorities,
            'status' => $status,
            'queues' => $queues,
            'ajaxPost' => Jquery::ajaxPostEditor('actionForm', 'message', '/tickets')
        ]);
    }

    /**
     * 
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return bool|mixed|string|TicketsController|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => ['required'],
                'userId' => ['required'],
                'queue' => ['required'],
                'subject' => ['required'],
                'message' => ['required'],
            ];
            $messages = [
                'name' => 'Nombre no es válido.',
                'userId' => 'UserID no es válido.',
                'queue' => 'Equipo no es válido.',
                'subject' => 'Asunto no es válido.',
                'message' => 'Mensaje no es válido.',
            ];
            if (in_array(UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles'])) {
                $rules['status'] = ['required'];
                $rules['priority'] = ['required'];
                $messages['status'] = 'Estado no es válido.';
                $messages['priority'] = 'Prioridad no es válida.';
            }
            $validated              = $request->validate($rules, $messages);
            $config                 = HTMLPurifier_Config::createDefault();
            $purifier               = new HTMLPurifier($config);
            $ticket                 = new Ticket();
            $ticket->status_id      = $request->input('status') || UtilHelper::globalKey('STATUS_OPEN');
            $ticket->priority_id    = $request->input('priority') || UtilHelper::globalKey('PRIORITY_HALF');
            $ticket->user_id        = $request->input('userId');
            $ticket->queue_id       = $request->input('queue');
            $ticket->subject        = $request->input('subject');
            $ticket->message        = $purifier->purify($request->input('message'));
            $ticket->files          = $request->input('files');
            $ticket->created_by     = Session::all()['id'];
            $assigned_agent         = empty($request->input('assigned_agent')) ? $request->input('assigned_agent') : null;
            $ticket->assigned_agent = $assigned_agent;
            $ticket->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'ADD|OK|TICKET:' . $ticket->id);
            LoggerHelper::ticket($request, 'Ticket creado por ' . Session::all()['name'], $ticket->id, $ticket, Session::all()['id']);
            $type = TypeNotification::where('type', 'NEW')->first();
            Notification::create([
                'type_notification_id'  => $type->id,
                'register_id'           => $ticket->id,
                'sent'                  => false,
                'execute'               => false
            ]);
            return response()->json(
                [
                    'success' => 'ok',
                    'data' => $ticket,
                ],
                201,
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
     * Summary of addMessage
     * @param \Illuminate\Http\Request $request
     * @return bool|mixed|string|TicketsController|\Illuminate\Http\JsonResponse
     */
    public function addMessage(Request $request)
    {
        try {
            $rules = [
                'ticket_id' => ['required'],
                'message'   => ['required'],
            ];
            $messages = [
                'ticket_id' => 'ID no es válido.',
                'message'   => 'Mensaje no es válido.',
            ];
            $validated          = $request->validate($rules, $messages);
            $config             = HTMLPurifier_Config::createDefault();
            $purifier           = new HTMLPurifier($config);
            $ticket             = new TicketMessage();
            $ticket->ticket_id  = $request->input('ticket_id');
            $ticket->created_by = Session::all()['id'];
            $ticket->message    = $purifier->purify($request->input('message'));
            $ticket->files      = $request->input('files');
            $ticket->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'ADD|OK|TICKETMESSAGE:' . $ticket->id);
            LoggerHelper::ticket($request, 'Nuevo mensaje creada por ' . Session::all()['name'], $ticket->ticket_id, $ticket, Session::all()['id']);
            $type = TypeNotification::where('type', 'MESSAGE')->first();
            Notification::create([
                'type_notification_id'  => $type->id,
                'register_id'           => $ticket->id,
                'sent'                  => false,
                'execute'               => false
            ]);
            return response()->json(
                [
                    'success' => 'ok',
                    'data' => $ticket,
                ],
                201,
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
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @return bool|mixed|string|TicketsController|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        if (!in_array(UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']) && in_array(UtilHelper::globalKey('ROLE_ADMIN'), Session::all()['roles'])) {
            abort(401);
        }
        try {
            $rules = [
                'status' => ['required'],
                'priority' => ['required'],
            ];
            $messages = [
                'status' => 'Estado no es válido.',
                'priority' => 'Prioridad no es válida.',
            ];
            $validated = $request->validate($rules, $messages);
            $ticket = Ticket::find($request->input('id'));
            if (empty($ticket)) {
                abort(404);
            }

            $old_status_id          = $ticket->status_id;
            $new_status_id          = $request->input('status');
            $ticket->assigned_agent = $request->input('assigned_agent');
            $ticket->status_id      = $request->input('status');
            $ticket->priority_id    = $request->input('priority');
            $ticket->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'UPDATE|OK|TICKET:' . $ticket->id);
            $action = 'Ticket actualizado por ' . Session::all()['name'];
            if ($old_status_id != $new_status_id) {
                $old_status = Status::find($old_status_id);
                $new_status = Status::find($new_status_id);
                $action .= '. Cambio de estado: ' . $old_status->status . ' &rarr; <b>' . $new_status->status . '</b>';
                $type = TypeNotification::where('type', 'CHANGE_STATUS')->first();
                Notification::create([
                    'type_notification_id'  => $type->id,
                    'register_id'           => $ticket->id,
                    'sent'                  => false,
                    'execute'               => false
                ]);
            }
            LoggerHelper::ticket($request, $action, $ticket->id, $ticket, Session::all()['id']);
            return response()->json(
                [
                    'success' => 'ok',
                    'data' => $ticket,
                ],
                201,
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
     * Summary of downloadFile
     * @param \Illuminate\Http\Request $request
     * @param mixed $type
     * @param mixed $id
     * @param mixed $downloadFile
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile(Request $request, $type = null, $id = null, $downloadFile = null)
    {
        if ($type == 1) {
            $record = Ticket::find($id);
            if (empty($record)) {
                abort(401);
            }
            if (!in_array(UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']) && !in_array(UtilHelper::globalKey('ROLE_ADMINISTRATOR'), Session::all()['roles'])) {
                if ($record->user_id != Session::all()['id']) {
                    abort(401);
                }
            }
        } else {
            $record = TicketMessage::find($id);
            if (empty($record)) {
                abort(401);
            }
            $ticket = Ticket::find($record->ticket_id);
            if (empty($ticket)) {
                abort(401);
            }
            if (!in_array(UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']) && !in_array(UtilHelper::globalKey('ROLE_ADMINISTRATOR'), Session::all()['roles'])) {
                if ($record->created_id != Session::all()['id'] && $ticket->user_id != Session::all()['id']) {
                    abort(401);
                }
            }
        }
        $path = null;
        $files = json_decode($record->files);
        foreach ($files as $file) {
            if ($file->fileName == $downloadFile) {
                $path = storage_path() . '/app/tmp/' . $downloadFile;
                break;
            }
        }

        if (!is_file($path)) {
            dd(1);
            abort(404, 'El archivo no existe');
        }
        return response()->download($path);
    }

    /**
     * 
     * Summary of userSearch
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function userSearch(Request $request)
    {
        $term       = $request->input('term');
        $results    = User::where('active', true)
            ->where('name', 'ILIKE', '%' . $term . '%')
            ->take(10)
            ->get(['id', 'name']);
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'value' => $result->name,
                'id' => $result->id,
            ];
        }
        return response()->json($data);
    }

    /**
     * 
     * Summary of agentQueue
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function agentQueue(Request $request)
    {
        $id         = $request->input('queue_id');
        $agentsIS   = QueueUser::where('queue_id', '=', $id)->get();
        $agents     = [];
        foreach ($agentsIS as $agent) {
            $user = User::find($agent->user_id);
            $agents[] = [
                'id' => $user->id,
                'text' => $user->name,
            ];
        }
        return response()->json($agents);
    }

    /**
     * 
     * Summary of addUserForm
     * @return \Illuminate\Contracts\View\View
     */
    public function addUserForm()
    {
        return view('tickets.addNewUser', [
            'title' => 'Usuarios',
        ]);
    }

    /**
     * 
     * Summary of addUser
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|string|TicketsController|\Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request)
    {
        $role_id    = UtilHelper::globalKey('ROLE_AGENT');
        $roles      = Session::all()['roles'];
        if (!in_array($role_id, $roles)) {
            abort(401);
        }
        try {
            $email = $request->input('email');
            $emailArray = explode('@', $email);
            $request->request->add(['login' => $emailArray[0]]);
            $validated = $request->validate(
                [
                    'name'  => ['required'],
                    'rut'   => ['unique:App\Models\User,rut', new RutRule()],
                    'email' => ['unique:App\Models\User,email', 'required'],
                    'login' => ['unique:App\Models\User,login', 'required'],
                ],
                [
                    'name'          => 'Nombre no es válido.',
                    'rut.unique'    => 'R.U.T. existe.',
                    'email.unique'  => 'Email existe.',
                    'login.required'=> 'Usuario no es válido.',
                    'login.unique'  => 'Nombre Usuario existe.',
                ],
            );
            $rut = preg_replace('/\./', '', $request->input('rut'));
            $user = User::where('email', '=', $request->input('email'))->orWhere('login', '=', $request->input('login'))->orWhere('rut', '=', $rut)->first();
            if ($user) {
                throw new Exception('Usuario registrado anteriormente.');
            }
            $user = new User();
            $user->email = mb_convert_case($request->input('email'), MB_CASE_LOWER);
            $user->login = mb_convert_case($request->input('login'), MB_CASE_LOWER);
            $user->rut = $rut;
            $user->name = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $user->active = true;
            $user->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request, 'ADD|OK|USER:' . $user->id);
            $type = TypeNotification::where('type', 'ADMIN')->first();
            Notification::create([
                'type_notification_id'  => $type->id,
                'register_id'           => $user->id,
                'sent'                  => false,
                'execute'               => false,
                'contents'              => 'Nuevo Usuario: ' . $user->name
            ]);
            return response()->json(
                [
                    'success' => 'ok',
                    'data' => $user,
                ],
                201,
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
     * Summary of uploadFile
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        try {
            $request->validate(
                [
                    'file'  => 'required|file|max:2048', // 2048 KB = 2 MB
                ],
                [
                    'file.required' => 'Archivo no valido.',
                    'file.file'     => 'Archivo no válido.',
                    'file.max'      => 'Archivo no debe superar los 2 MB.',
                ],
            );
            $pathTmp = storage_path() . '/app/tmp/';
            if (!is_dir($pathTmp)) {
                if (!mkdir($pathTmp)) {
                    throw new Exception('Directorio temporal no disponible.');
                }
            }
            $file       = $request->file('file');
            $fileName   = $file->getClientOriginalName();
            $extension  = $file->getClientOriginalExtension();
            $fileType   = $request->input('type');
            $fileType   = explode(',', $fileType);
            if (!in_array($extension, $fileType)) {
                throw new Exception('Extensión del archivo no valido.');
            }
            $fileName = preg_replace('/\ /', '_', $fileName);
            $newFileName = Str::uuid() . '___' . $fileName;
            $path = $file->storeAs('tmp', $newFileName, 'app');
            if (!$path) {
                throw new Exception('Error al guardar el archivo.');
            }
            LoggerHelper::add($request, 'ADD|OK|FILE:' . basename($newFileName));
            $sizeInMB = round($file->getSize() / (1024 * 1024), 2);
            $data = [
                'fileOriginalName'  => $file->getClientOriginalName(),
                'fileName'          => $newFileName,
                'size'              => $sizeInMB,
                'name'              => $file->getClientOriginalName() . ' (' . $sizeInMB . 'MB)',
            ];
            return response()->json(['success' => 'ok', 'data' => $data]);
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
}
