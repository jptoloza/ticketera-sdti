<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthTicket;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Session;
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

    // Admin Routes //
    Route::get('/admin', [IndexController::class, 'index'])
        ->name('admin');

    
    // User Routes //

    Route::get('/admin/users/',[UserController::class, 'index'])
        ->name('admin-users');

    Route::get('/admin/users/get',[UserController::class, 'getUsers'])
        ->name('admin-users-get');

    Route::get('/admin/users/delete/{id}',[UserController::class, 'delete'])
        ->name('admin-users-delete');


    // Auxiliary Tables //

    Route::get('/admin/roles/', [RoleController::class, 'index'])
        ->name('admin-roles');

    Route::get('/admin/roles/get',[RoleController::class, 'getRoles'])
        ->name('admin-roles-get');


});
