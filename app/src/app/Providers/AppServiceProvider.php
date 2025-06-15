<?php

namespace App\Providers;

use App\Models\Queue;
use App\Models\Ticket;
use App\Http\Helpers\UtilHelper;
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
            $userSession = SessionHelper::current();
            $role_agent = UtilHelper::globalKey('ROLE_AGENT');
            $status_open = UtilHelper::globalKey('STATUS_OPEN');
            if ($userSession->id && in_array($role_agent, $userSession->roles)) {
                $queues = Queue::whereHas('users', function ($q) use ($userSession) {
                    $q->where('user_id', $userSession->id);
                })->where('active', true)->get();
                $status_open = UtilHelper::globalKey('STATUS_OPEN');
                foreach ($queues as $queue) {
                    $dataQueue[$queue->id] = Ticket::where('queue_id', $queue->id)
                        ->where('status_id', $status_open)->count();
                }
            }
            $view->with([
                'userQueues'    => $queues,
                'dataQueue'     => $dataQueue
            ]);
        });
    }
}
