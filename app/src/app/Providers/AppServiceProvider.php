<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\View;
    use App\Models\Queue;
    use App\Http\Helpers\UserSession;

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
                $user = \App\Http\Helpers\UserSession::current();

                if (!$user) {
                    // No hay usuario autenticado, pasa un arreglo vacío
                    return $view->with('userQueues', []);
                }
            
                $queues = \App\Models\Queue::whereHas('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->get();
            
                $view->with('userQueues', $queues);
            });
        }
    }
