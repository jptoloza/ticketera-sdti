<?php

namespace App\Providers;

use App\Models\Queue;
use App\Models\Ticket;
use App\Models\QueueUser;
use App\Http\Helpers\UtilHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\SessionHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.menu', function ($view) {
            $queues = [];
            $dataQueue = [];
            $myAsignedTickets = 0;
            $myTickets = 0;
            $userSession = SessionHelper::current();
            if ($userSession->id && (in_array('ROLE_AGENT', $userSession->roles) ||
                in_array('ROLE_MANAGER', $userSession->roles))) {                    
                $queues = QueueUser::join('queues', function ($join) {
                    $join->on('queues.id', '=', 'queue_users.queue_id')
                        ->where('queues.active', '=', true);
                })
                    ->join('users', function ($join) {
                        $join->on('users.id', '=', 'queue_users.user_id')
                            ->where('users.active', '=', true);
                    })
                    ->whereNull('queue_users.deleted_at')
                    ->where('queue_users.user_id',$userSession->id)
                    ->select(
                        'queues.id',
                        'queues.queue'
                    )->get();
                $status_open = UtilHelper::globalKey('STATUS_OPEN');
                foreach ($queues as $queue) {
                    $dataQueue[$queue->id] = Ticket::where('queue_id', $queue->id)
                        ->whereNull('assigned_agent')
                        ->where('status_id', UtilHelper::globalKey('STATUS_OPEN'))
                        ->count();
                }
                $myAsignedTickets = Ticket::where('assigned_agent', $userSession->id)
                    ->whereNotIn('status_id', [
                        UtilHelper::globalKey('STATUS_CLOSED'),
                        UtilHelper::globalKey('STATUS_CANCELLED'),
                    ])
                    ->count();
            }
            $myTickets = Ticket::where('user_id', $userSession->id)
                ->where('status_id', '!=', UtilHelper::globalKey('STATUS_CLOSED'))
                ->where('status_id', '!=', UtilHelper::globalKey('STATUS_CANCELLED'))
                ->count();
            $view->with([
                'userQueues'        => $queues,
                'dataQueue'         => $dataQueue,
                'myTickets'         => $myTickets,
                'myAsignedTickets'  => $myAsignedTickets
            ]);
        });
    }
}
