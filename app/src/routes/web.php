<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthTicket;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Agent\RequestsController as AgentRequestController;
use App\Http\Controllers\Users\RequestsController as UsersRequestController;
use App\Http\Controllers\Administrator\IndexController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\Administrator\AuxiliaryTables\RoleController;



Route::get('/', [LoginController::class, 'Index'])
    ->name('index');

Route::get('/cas/login', [LoginController::class, 'LoginCAS'])
    ->name('login_cas');

Route::get('/logout', [LoginController::class, 'Logout'])
    ->name('logout');


Route::middleware([AuthTicket::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Index'])
        ->name('dashboard');






    //
    Route::get('/agent/request/{id}', [AgentRequestController::class, 'Show'])
        ->name('agent_reqest_id');
    Route::get('/agent/request', [AgentRequestController::class, 'Index'])
        ->name('agent_request');

    //
    Route::get('/users/request/[id]', [UsersRequestController::class, 'Index'])
        ->name('user_request_id');
    Route::get('/users/request', [UsersRequestController::class, 'Show'])
        ->name('user_request');



         // Admin Routes //
    Route::get('/admin', [IndexController::class, 'index'])
        ->name('admin');
    
    // User Routes //

    Route::get('/admin/users/',[UserController::class, 'index'])
        ->name('admin_users');

    Route::get('/admin/users/get',[UserController::class, 'getUsers'])
        ->name('admin_users_get');

    Route::get('/admin/users/delete/{id}',[UserController::class, 'delete'])
        ->name('admin_users_delete');


    // Auxiliary Tables //

    Route::get('/admin/roles/', [RoleController::class, 'index'])
        ->name('admin_roles');

    Route::get('/admin/roles/get',[RoleController::class, 'getRoles'])
        ->name('admin_roles_get');


});
