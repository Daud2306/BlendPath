<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\SubmodulController;
use App\Http\Controllers\TanyaController;
use App\Http\Controllers\JawabController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TinyMCEController;

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\ExportPdfController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [AuthController::class, 'home'])->name('home');

Route::view('/about', 'user.about');

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/register', 'showRegisterForm')->name('register');
        Route::post('/register', 'register')->name('register.process');
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.process');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//user

Route::middleware(['auth', 'role:user'])
    ->prefix('learn')
    ->name('learn.')
    ->group(function () {

        Route::get('moduls', [ModulController::class, 'index'])
            ->name('moduls.index');

        Route::get('moduls/{modul}', [ModulController::class, 'show'])
            ->name('moduls.show');

        Route::get(
            'moduls/{modul}/submoduls/{sort_order}',
            [SubmodulController::class, 'userShow']
        )->name('submoduls.show');

        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/complete',
            [ProgressController::class, 'markAsCompleted']
        )->name('submoduls.complete');

        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/incomplete',
            [ProgressController::class, 'markAsIncomplete']
        )->name('submoduls.incomplete');

        Route::prefix('quizzes')
            ->name('quizzes.')
            ->group(function () {

                Route::get('{quiz}/take', [QuizController::class, 'showQuiz'])
                    ->name('take');

                Route::post('{quiz}/submit', [QuizController::class, 'submit'])
                    ->name('submit');

                Route::get('{quiz}/result', [QuizController::class, 'result'])
                    ->name('result');
            });

        Route::resource('tanyas', TanyaController::class)
            ->only(['store', 'destroy']);

        Route::resource('jawabs', JawabController::class)
            ->only(['store', 'update', 'destroy']);

        Route::prefix('tinymce')->name('tinymce.')->group(function () {
            Route::post('upload', [TinyMCEController::class, 'upload'])->name('upload');
            Route::post('upload-video', [TinyMCEController::class, 'uploadVideo'])->name('upload.video');
            Route::delete('media/{id}', [TinyMCEController::class, 'delete'])->name('media.delete');
        });
    });

//admin

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('dashboard', 'admin.dashboard')->name('dashboard');

        Route::get('search', [AdminSearchController::class, 'search'])
            ->name('search');

        Route::resource('moduls', ModulController::class)
            ->except(['show'])
            ->names('moduls');

        Route::resource('moduls.submoduls', SubmodulController::class)
            ->except(['show'])
            ->names('moduls.submoduls');

        Route::resource(
            'moduls.submoduls.quizzes',
            QuizController::class
        )->except(['index', 'show'])
            ->names('moduls.submoduls.quizzes');

        Route::resource('users', UserManagementController::class)
            ->except(['show'])
            ->names('users');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('export', [UserManagementController::class, 'export'])->name('export');
            Route::post('import', [UserManagementController::class, 'import'])->name('import');
            Route::get('template', [UserManagementController::class, 'downloadTemplate'])->name('template');
            Route::get('export-pdf', [ExportPdfController::class, 'usersExportPdf'])->name('view-pdf');
        });

        Route::get('monitoring', [UserManagementController::class, 'monitoring'])
            ->name('monitoring.index');

        Route::resource('tanyas', TanyaController::class)
            ->only(['index', 'destroy'])
            ->names('tanyas');
    });

Route::get('/storage/{path}', function ($path) {

    $fullPath = storage_path('app/public/' . $path);

    abort_unless(File::exists($fullPath), 404);

    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');
