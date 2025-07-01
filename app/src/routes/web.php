<?php

use App\Http\Middleware\AuthRole;
use App\Http\Middleware\AuthTicket;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Administrator\RoleController;
use App\Http\Controllers\Administrator\UnitsController;
use App\Http\Controllers\Administrator\QueuesController;
use App\Http\Controllers\Administrator\StatusController;
use App\Http\Controllers\Administrator\UserController as UsersController;
//
//
use App\Http\Controllers\Agent\RequestsController as AgentRequestController;
use App\Http\Controllers\Users\RequestsController as UsersRequestController;
use App\Http\Controllers\Administrator\IndexController as DashboardAdminController;



Route::get('/', [LoginController::class, 'index'])
    ->name('index');

Route::get('/cas/login', [LoginController::class, 'loginCAS'])
    ->name('login_cas');

Route::post('/signin', [LoginController::class, 'loginEmail'])
    ->name('login_email');

Route::post('/signin/validate', [LoginController::class, 'loginEmailValidate'])
    ->name('login_email_validate');

Route::get('/login/error', [LoginController::class, 'loginError'])
    ->name('login_error');



Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');


Route::middleware([AuthTicket::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    Route::post('/user/register/update', [UserController::class, 'updateRegister'])
        ->name('user_register_update');

    Route::get('/user/register', [UserController::class, 'registerForm'])
        ->name('user_register_form');

    Route::post('/user/update', [UserController::class, 'update'])
        ->name('user_update');

    Route::get('/user', [UserController::class, 'index'])
        ->name('user');




    // Tickets

    Route::get('/tickets/add', [TicketsController::class, 'create'])
        ->name('tickets_addForm');

    Route::post('/tickets/add', [TicketsController::class, 'store'])
        ->name('tickets_add');

    Route::get('/tickets/userSearch', [TicketsController::class, 'userSearch'])
        ->name('tickets_userSearch');

    Route::get('/tickets/agentsQueue', [TicketsController::class, 'agentQueue'])
        ->name('tickets_agentsQueue');

    Route::get('/tickets/addUserFOrm', [TicketsController::class, 'addUserForm'])
        ->name('tickets_newUser_form');

    Route::post('/tickets/addUser', [TicketsController::class, 'addUser'])
        ->name('tickets_newUser');

    Route::post('/tickets/addFile', [TicketsController::class, 'uploadFile'])
        ->name('tickets_addFile');

    Route::get('/tickets/download/{type}/{id}/{file}', [TicketsController::class, 'downloadFile'])
        ->name('tickets_downloadFile')->where(['type' => '[1-2]']);

    Route::Post('/tickets/addMessage', [TicketsController::class, 'addMessage'])
        ->name('tickets_addMessage');

    Route::get('/tickets/no-assigned/{queueId}', [TicketsController::class, 'indexNoAssignedByQueue'])
        ->name('tickets.noAssigned.queue');

    Route::get('/tickets/assigned', [TicketsController::class, 'indexAssigned'])
        ->name('tickets.assigned');

    Route::get('/tickets/queue/{queueId}', [TicketsController::class, 'indexByQueue'])
        ->name('tickets.byQueue');

    Route::Post('/tickets/update', [TicketsController::class, 'update'])
        ->name('tickets_update');

    Route::get('/tickets/{id}', [TicketsController::class, 'view'])
        ->name('tickets_view');

    Route::get('/tickets', [TicketsController::class, 'index'])
        ->name('tickets');





    // Admin

    Route::middleware([AuthRole::class . ':ROLE_ADMINISTRATOR'])->group(function () {

        // Admin Routes //
        Route::get('/admin', [DashboardAdminController::class, 'index'])
            ->name('admin');

        // Users
        Route::get('/admin/users/', [UsersController::class, 'index'])
            ->name('admin_users');

        Route::get('/admin/users/get', [UsersController::class, 'get'])
            ->name('admin_users_get');

        Route::get('/admin/users/add', [UsersController::class, 'create'])
            ->name('admin_users_add_form');

        Route::post('/admin/users/add', [UsersController::class, 'store'])
            ->name('admin_users_add');

        Route::get('/admin/users/edit/{id}', [UsersController::class, 'edit'])
            ->name('admin_users_editForm');

        Route::post('/admin/users/edit', [UsersController::class, 'update'])
            ->name('admin_users_edit');

        Route::get('/admin/users/delete/{id}', [UsersController::class, 'destroy'])
            ->name('admin_users_delete');


        // Academic Units

        Route::get('/admin/units/', [UnitsController::class, 'index'])
            ->name('admin_units');

        Route::get('/admin/units/get', [UnitsController::class, 'get'])
            ->name('admin_units_get');

        Route::get('/admin/units/add', [UnitsController::class, 'create'])
            ->name('admin_units_addForm');

        Route::post('/admin/units/add', [UnitsController::class, 'store'])
            ->name('admin_units_add');

        Route::get('/admin/units/edit/{id}', [UnitsController::class, 'edit'])
            ->name('admin_units_editForm');

        Route::post('/admin/units/edit', [UnitsController::class, 'update'])
            ->name('admin_units_edit');

        Route::get('/admin/units/delete/{id}', [UnitsController::class, 'destroy'])
            ->name('admin_units_delete');



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

        Route::get('/admin/status/add', [StatusController::class, 'create'])
            ->name('admin_status_addForm');

        Route::post('/admin/status/add', [StatusController::class, 'store'])
            ->name('admin_status_add');

        Route::get('/admin/status/edit/{id}', [StatusController::class, 'edit'])
            ->name('admin_status_editForm');

        Route::post('/admin/status/edit', [StatusController::class, 'update'])
            ->name('admin_status_edit');

        Route::get('/admin/status/delete/{id}', [StatusController::class, 'destroy'])
            ->name('admin_status_delete');
    });
});
