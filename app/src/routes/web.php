<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthTicket;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Session;



Route::get('/', [LoginController::class, 'Index'])
    ->name('index');

Route::get('/cas/login', [LoginController::class, 'LoginCAS'])
    ->name('login_cas');

Route::get('/logout', [LoginController::class, 'Logout'])
    ->name('logout');


Route::middleware([AuthTicket::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Index'])
        ->name('dashboard');





    // Admin routes
    Route::get('/admin', [DashboardController::class, 'Index'])
        ->name('admin');
});
