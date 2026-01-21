<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeaderController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    //Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
        ->name('dashboard');

    //Header Route
    Route::get('/header', [HeaderController::class, 'showHeader'])
        ->name('header');

    Route::get('/header/add', [HeaderController::class, 'addHeader'])
        ->name('header.add');


    Route::post('/header/store', [HeaderController::class, 'store'])
        ->name('header.store');

    Route::get('/header/edit/{id}', [HeaderController::class, 'editHeader'])
        ->name('header.edit');

    Route::put('/header/update/{id}', [HeaderController::class, 'updateHeader'])
        ->name('header.update');

    // Delete Header
    Route::delete('/header/delete/{id}', [HeaderController::class, 'deleteHeader'])
        ->name('header.delete');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
