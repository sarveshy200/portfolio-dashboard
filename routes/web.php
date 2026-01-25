<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\AboutusController;
use App\Http\Controllers\SkillsController;

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


    //Aboutus Route
    Route::get('/aboutus', [AboutusController::class, 'showAboutus'])
        ->name('aboutus');

    Route::get('/aboutus/add', [AboutusController::class, 'addAbout'])
        ->name('aboutus.add');

    Route::post('/aboutus/store', [AboutusController::class, 'storeAbout'])->name('aboutus.store');

    Route::get('/aboutus/edit/{id}', [AboutusController::class, 'editAbout'])
        ->name('aboutus.edit');

    Route::put('/aboutus/update/{id}', [AboutusController::class, 'updateAbout'])
        ->name('aboutus.update');

    // Delete About Us
    Route::delete('/aboutus/delete/{id}', [AboutusController::class, 'deleteAbout'])->name('aboutus.delete');



    // Skills Routes
    Route::get('/skills', [SkillsController::class, 'showSkills'])->name('skills');
    Route::get('/skills/add', [SkillsController::class, 'addSkill'])->name('skills.add');
    Route::post('/skills/store', [SkillsController::class, 'storeSkill'])->name('skills.store');
    Route::get('/skills/edit/{id}', [SkillsController::class, 'editSkill'])->name('skills.edit');
    Route::put('/skills/update/{id}', [SkillsController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/delete/{id}', [SkillsController::class, 'deleteSkill'])->name('skills.delete');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
