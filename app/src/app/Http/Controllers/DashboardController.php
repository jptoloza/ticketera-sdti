<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Helpers\SessionHelper;

class DashboardController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * 
     */
    public function index(Request $request)
    {
        $userSession = SessionHelper::current();
        $queues = Queue::whereHas('users', function ($q) use ($userSession) {
            $q->where('user_id', $userSession->id);
        })->where('active',true)->get();
        $data = [];
        $status_open = UtilHelper::globalKey('STATUS_OPEN');
        foreach($queues as $queue) {
            $data[$queue->id] = Ticket::where('queue_id', $queue->id)
                                ->where('status_id', $status_open)->count();
        }

        return view('dashboard', [
            'title'         => 'SDTI: ServiceDesk',
            'userQueues'    => $queues,
            'dataQueue'     => $data

        ]);
    }
}
