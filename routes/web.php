<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// user
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\SubmodulController;
use App\Http\Controllers\TanyaController;
use App\Http\Controllers\JawabController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TinyMCEController;

// admin
use App\Http\Controllers\Admin\ModulController      as AdminModulController;
use App\Http\Controllers\Admin\SubmodulController   as AdminSubmodulController;
use App\Http\Controllers\Admin\QuizController       as AdminQuizController;
use App\Http\Controllers\Admin\TanyaController      as AdminTanyaController;
use App\Http\Controllers\Admin\JawabController      as AdminJawabController;
use App\Http\Controllers\Admin\UserController       as AdminUserController;
use App\Http\Controllers\Admin\SearchController     as AdminSearchController;
use App\Http\Controllers\Admin\ExportPdfController  as AdminExportPdfController;
use App\Http\Controllers\Admin\DashboardController  as AdminDashboardController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ShowcaseController;
use Illuminate\Support\Facades\Auth;

// route auth
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

Route::middleware('auth')->group(function () {
    Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');
});

// route user
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
            [SubmodulController::class, 'show']
        )->name('submoduls.show');

        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/complete',
            [ProgressController::class, 'markAsCompleted']
        )->name('submoduls.complete');

        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/incomplete',
            [ProgressController::class, 'markAsIncomplete']
        )->name('submoduls.incomplete');

        Route::prefix('quizzes')->name('quizzes.')->group(function () {
            Route::get('{quiz}/take',   [AdminQuizController::class, 'showQuiz'])->name('take');
            Route::post('{quiz}/submit', [AdminQuizController::class, 'submit'])->name('submit');
            Route::get('{quiz}/result', [AdminQuizController::class, 'result'])->name('result');
        });

        Route::resource('tanyas', TanyaController::class)
            ->only(['store', 'edit', 'update', 'destroy']);

        Route::resource('jawabs', JawabController::class)
            ->only(['store', 'edit', 'update', 'destroy']);

        Route::prefix('tinymce')->group(function () {
            Route::post('upload',         [TinyMCEController::class, 'upload']);
            Route::delete('media/{id}',   [TinyMCEController::class, 'delete']);
            Route::get('list',            [TinyMCEController::class, 'index']);
        });

        Route::prefix('showcase')->name('showcase.')->group(function () {
            Route::get('/',             [ShowcaseController::class, 'index'])->name('index');
            Route::get('/create',       [ShowcaseController::class, 'create'])->name('create');
            Route::post('/',            [ShowcaseController::class, 'store'])->name('store');
            Route::get('/{showcase}',   [ShowcaseController::class, 'show'])->name('show');
            Route::delete('/{showcase}', [ShowcaseController::class, 'destroy'])->name('destroy');

            Route::post('/{showcase}/komentar',       [ShowcaseController::class, 'storeKomentar'])->name('komentar.store');
            Route::delete('/komentar/{komentar}',     [ShowcaseController::class, 'destroyKomentar'])->name('komentar.destroy');
        });
    });

// route admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('search', [AdminSearchController::class, 'search'])
            ->name('search');

        Route::resource('moduls', AdminModulController::class)
            ->names('moduls');

        Route::resource('moduls.submoduls', AdminSubmodulController::class)
            ->names('moduls.submoduls');

        Route::resource('moduls.submoduls.quizzes', AdminQuizController::class)
            ->except(['index'])
            ->names('moduls.submoduls.quizzes');

        Route::resource('users', AdminUserController::class)
            ->except(['show'])
            ->names('users');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('export',      [AdminUserController::class,      'export'])->name('export');
            Route::post('import',     [AdminUserController::class,      'import'])->name('import');
            Route::get('template',    [AdminUserController::class,      'downloadTemplate'])->name('template');
            Route::get('export-pdf',  [AdminExportPdfController::class, 'usersExportPdf'])->name('view-pdf');
        });

        Route::get('monitoring', [AdminUserController::class, 'monitoring'])
            ->name('monitoring.index');

        Route::resource('tanyas', AdminTanyaController::class)
            ->only(['index', 'destroy'])
            ->names('tanyas');

        Route::resource('jawabs', AdminJawabController::class)
            ->only(['index', 'destroy'])
            ->names('jawabs');
    });

//storage
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    abort_unless(File::exists($fullPath), 404);
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');
