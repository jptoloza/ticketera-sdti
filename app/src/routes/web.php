<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthTicket;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Agent\RequestsController as AgentRequestController;
use App\Http\Controllers\Users\RequestsController as UsersRequestController;


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
        ->name('aent_reqest_id');
    Route::get('/agent/request', [AgentRequestController::class, 'Index'])
        ->name('agent_request');

    //
    Route::get('/users/request/[id]', [UsersRequestController::class, 'Index'])
        ->name('user_request_id');
    Route::get('/users/request', [UsersRequestController::class, 'Show'])
        ->name('user_request');
    //
    Route::get('/admin', [DashboardController::class, 'Index'])
        ->name('admin');
});
