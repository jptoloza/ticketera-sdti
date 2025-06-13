<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthTicket;
use App\Http\Middleware\AuthRole;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Administrator\IndexController as DashboardAdminController;
use App\Http\Controllers\Administrator\UserController;

use App\Http\Controllers\Agent\RequestsController as AgentRequestController;
use App\Http\Controllers\Users\RequestsController as UsersRequestController;

use App\Http\Controllers\Administrator\RoleController;
use App\Http\Controllers\Administrator\QueuesController;
use App\Http\Controllers\Administrator\StatusController;



Route::get('/', [LoginController::class, 'index'])
    ->name('index');

Route::get('/cas/login', [LoginController::class, 'loginCAS'])
    ->name('login_cas');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');


Route::middleware([AuthTicket::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');






    //
    Route::get('/agent/request/{id}', [AgentRequestController::class, 'show'])
        ->name('agent_reqest_id');
    Route::get('/agent/request', [AgentRequestController::class, 'index'])
        ->name('agent_request');

    //
    Route::get('/users/request/[id]', [UsersRequestController::class, 'index'])
        ->name('user_request_id');
    Route::get('/users/request', [UsersRequestController::class, 'show'])
        ->name('user_request');





    Route::middleware([AuthRole::class . ':1'])->group(function () {

        // Admin Routes //
        Route::get('/admin', [DashboardAdminController::class, 'index'])
            ->name('admin');

        // Users
        Route::get('/admin/users/', [UserController::class, 'index'])
            ->name('admin_users');

        Route::get('/admin/users/get', [UserController::class, 'get'])
            ->name('admin_users_get');

        Route::get('/admin/users/add', [UserController::class, 'create'])
            ->name('admin_users_add_form');

        Route::post('/admin/users/add', [UserController::class, 'store'])
            ->name('admin_users_add');

        Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])
            ->name('admin_users_editForm');

        Route::post('/admin/users/edit', [UserController::class, 'update'])
            ->name('admin_users_edit');

        Route::get('/admin/users/delete/{id}', [UserController::class, 'destroy'])
            ->name('admin_users_delete');

        // Roles
        Route::get('/admin/roles/', [RoleController::class, 'index'])
            ->name('admin_roles');

        Route::get('/admin/roles/get', [RoleController::class, 'get'])
            ->name('admin_roles_get');

        Route::get('/admin/roles/add', [RoleController::class, 'create'])
            ->name('admin_roles_addForm');

        Route::post('/admin/roles/add', [RoleController::class, 'store'])
            ->name('admin_roles_add');

        Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])
            ->name('admin_roles_editForm');

        Route::post('/admin/roles/edit', [RoleController::class, 'update'])
            ->name('admin_roles_edit');

        Route::get('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])
            ->name('admin_roles_delete');

        Route::get('/admin/roles/users/{id}', [RoleController::class, 'users'])
            ->name('admin_roles_users');

        Route::post('/admin/roles/users/add', [RoleController::class, 'addUser'])
            ->name('admin_roles_users_add');

        Route::get('/admin/roles/users/delete/{id}', [RoleController::class, 'deleteUser'])
            ->name('admin_roles_users_delete');




        // AKI

       // Queues
        Route::get('/admin/queues/', [QueuesController::class, 'index'])
            ->name('admin_queues');

        Route::get('/admin/queues/get', [QueuesController::class, 'get'])
            ->name('admin_queues_get');

        Route::get('/admin/queues/add', [QueuesController::class, 'create'])
            ->name('admin_queues_addForm');

        Route::post('/admin/queues/add', [QueuesController::class, 'store'])
            ->name('admin_queues_add');

        Route::get('/admin/queues/edit/{id}', [QueuesController::class, 'edit'])
            ->name('admin_queues_editForm');

        Route::post('/admin/queues/edit', [QueuesController::class, 'update'])
            ->name('admin_queues_edit');

        Route::get('/admin/queues/delete/{id}', [QueuesController::class, 'destroy'])
            ->name('admin_queues_delete');

        Route::get('/admin/queues/users/{id}', [QueuesController::class, 'users'])
            ->name('admin_queues_users');

        Route::post('/admin/queues/users/add', [QueuesController::class, 'addUser'])
            ->name('admin_queues_users_add');

        Route::get('/admin/queues/users/delete/{id}', [QueuesController::class, 'deleteUser'])
            ->name('admin_queues_users_delete');


        // Status
        Route::get('/admin/status/', [StatusController::class, 'index'])
            ->name('admin_status');

        Route::get('/admin/status/get', [StatusController::class, 'get'])
            ->name('admin_status_get');

        Route::get('/admin/status/add', [StatusController::class, 'addForm'])
            ->name('admin_status_addForm');

        Route::post('/admin/status/add', [StatusController::class, 'add'])
            ->name('admin_statusadd');

        Route::get('/admin/status/edit/{id}', [StatusController::class, 'editForm'])
            ->name('admin_status_editForm');

        Route::post('/admin/status/edit', [StatusController::class, 'edit'])
            ->name('admin_status_edit');

        Route::get('/admin/status/delete/{id}', [StatusController::class, 'delete'])
            ->name('admin_status_delete');
    });
});
