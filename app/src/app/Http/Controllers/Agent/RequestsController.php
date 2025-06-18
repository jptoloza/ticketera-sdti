<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{
    //

    public function Index(Request $request)
    {
        echo "Agent";
    }

    public function show($queueId)
    {
        $userId = session('id');

        $hasAccess = User::find($userId)?->queues->contains('id', $queueId);
        if (!$hasAccess) {
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
                'queues.queue',
                'users.name',
                'users.email'
            )
            ->get();

        return view('tickets.indexQueue', [
            'title' => 'Todos los tickets de la cola',
            'tickets' => $tickets,
        ]);
    }


}
