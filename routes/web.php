<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\AboutusController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Only for non-logged-in users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Show Login Page
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Handle Login Form Submit
    Route::post('/login', [AuthController::class, 'login']);
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Only for logged-in users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Header Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('header')->group(function () {

        Route::get('/', [HeaderController::class, 'showHeader'])
            ->name('header');

        Route::get('/add', [HeaderController::class, 'addHeader'])
            ->name('header.add');

        Route::post('/store', [HeaderController::class, 'store'])
            ->name('header.store');

        Route::get('/edit/{id}', [HeaderController::class, 'editHeader'])
            ->name('header.edit');

        Route::put('/update/{id}', [HeaderController::class, 'updateHeader'])
            ->name('header.update');

        Route::delete('/delete/{id}', [HeaderController::class, 'deleteHeader'])
            ->name('header.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | About Us Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('aboutus')->group(function () {

        Route::get('/', [AboutusController::class, 'showAboutus'])
            ->name('aboutus');

        Route::get('/add', [AboutusController::class, 'addAbout'])
            ->name('aboutus.add');

        Route::post('/store', [AboutusController::class, 'storeAbout'])
            ->name('aboutus.store');

        Route::get('/edit/{id}', [AboutusController::class, 'editAbout'])
            ->name('aboutus.edit');

        Route::put('/update/{id}', [AboutusController::class, 'updateAbout'])
            ->name('aboutus.update');

        Route::delete('/delete/{id}', [AboutusController::class, 'deleteAbout'])
            ->name('aboutus.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Skills Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('skills')->group(function () {

        Route::get('/', [SkillsController::class, 'showSkills'])
            ->name('skills');

        Route::get('/add', [SkillsController::class, 'addSkill'])
            ->name('skills.add');

        Route::post('/store', [SkillsController::class, 'storeSkill'])
            ->name('skills.store');

        Route::get('/edit/{id}', [SkillsController::class, 'editSkill'])
            ->name('skills.edit');

        Route::put('/update/{id}', [SkillsController::class, 'updateSkill'])
            ->name('skills.update');

        Route::delete('/delete/{id}', [SkillsController::class, 'deleteSkill'])
            ->name('skills.delete');
    });


     /*
    |--------------------------------------------------------------------------
    | Education Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('education')->group(function () {

        Route::get('/', [EducationController::class, 'showEducation'])
            ->name('education');

        Route::get('/add', [EducationController::class, 'addEducation'])
            ->name('education.add');

        Route::post('/store', [EducationController::class, 'storeEducation'])
            ->name('education.store');

        Route::get('/edit/{id}', [EducationController::class, 'editEducation'])
            ->name('education.edit');

        Route::put('/update/{id}', [EducationController::class, 'updateEducation'])
            ->name('education.update');

        Route::delete('/delete/{id}', [EducationController::class, 'deleteEducation'])
            ->name('education.delete');
    });


      /*
    |--------------------------------------------------------------------------
    | Education Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('experience')->group(function () {

        Route::get('/', [ExperienceController::class, 'showExperience'])
            ->name('experience');

        Route::get('/add', [ExperienceController::class, 'addExperience'])
            ->name('experience.add');

        Route::post('/store', [ExperienceController::class, 'storeExperience'])
            ->name('experience.store');

        Route::get('/edit/{id}', [ExperienceController::class, 'editExperience'])
            ->name('experience.edit');

        Route::put('/update/{id}', [ExperienceController::class, 'updateExperience'])
            ->name('experience.update');

        Route::delete('/delete/{id}', [ExperienceController::class, 'deleteExperience'])
            ->name('experience.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */
    Route::prefix('projects')->group(function () {

        Route::get('/', [ProjectController::class, 'showProjects'])
            ->name('projects');

        Route::get('/add', [ProjectController::class, 'addProjects'])
            ->name('project.add');

        Route::post('/store', [ProjectController::class, 'storeProjects'])
            ->name('project.store');

        Route::get('/edit/{id}', [ProjectController::class, 'editProjects'])
            ->name('project.edit');

        Route::put('/update/{id}', [ProjectController::class, 'updateProjects'])
            ->name('project.update');

        Route::delete('/delete/{id}', [ProjectController::class, 'deleteProjects'])
            ->name('project.delete');
    });



    /*
    |--------------------------------------------------------------------------
    | Logout Route
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
