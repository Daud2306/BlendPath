<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\SubmodulController;
use App\Http\Controllers\TanyaController;
use App\Http\Controllers\JawabController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Exporter\Exporter;

Route::get('/', function () {
    return view('user.index');
});

Route::get('/about', function () {
    return view('user.about');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('moduls')->name('moduls.')->group(function () {
    Route::get('/', [ModulController::class, 'index'])->name('index');
    Route::get('{modul}/submoduls', [ModulController::class, 'show'])->name('show');
    Route::get('{modul}/submoduls/{sort_order}', [SubmodulController::class, 'userShow'])->name('submoduls.show');

    Route::post('{modul}/submoduls/{sort_order}/complete', [ProgressController::class, 'markAsCompleted'])
        ->name('submoduls.complete');
    Route::post('{modul}/submoduls/{sort_order}/incomplete', [ProgressController::class, 'markAsIncomplete'])
        ->name('submoduls.incomplete');
});

Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('search', [AdminSearchController::class, 'search'])->name('search');

    Route::prefix('moduls')->name('moduls.')->group(function () {
        Route::get('/', [ModulController::class, 'adminIndex'])->name('index');
        Route::get('create', [ModulController::class, 'create'])->name('create');
        Route::post('/', [ModulController::class, 'store'])->name('store');
        Route::get('{modul}/edit', [ModulController::class, 'edit'])->name('edit');
        Route::put('{modul}', [ModulController::class, 'update'])->name('update');
        Route::delete('{modul}', [ModulController::class, 'destroy'])->name('destroy');

        Route::post('{modul}/submoduls/{submodul}/resources', [SubmodulController::class, 'updateResources'])
            ->name('submoduls.resources.store');
        Route::delete('{modul}/submoduls/{submodul}/resources/{resource}', [SubmodulController::class, 'destroyResource'])
            ->name('submoduls.resources.destroy');

        Route::get('{modul}/submoduls', [ModulController::class, 'adminShow'])->name('submoduls.index');
        Route::get('{modul}/submoduls/create', [SubmodulController::class, 'create'])->name('submoduls.create');
        Route::post('{modul}/submoduls', [SubmodulController::class, 'store'])->name('submoduls.store');
        Route::get('{modul}/submoduls/{submodul}', [SubmodulController::class, 'adminShow'])->name('submoduls.show');
        Route::get('{modul}/submoduls/{submodul}/edit', [SubmodulController::class, 'edit'])->name('submoduls.edit');
        Route::put('{modul}/submoduls/{submodul}', [SubmodulController::class, 'update'])->name('submoduls.update');
        Route::delete('{modul}/submoduls/{submodul}', [SubmodulController::class, 'destroy'])->name('submoduls.destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('{user}', [UserManagementController::class, 'destroy'])->name('destroy');

        Route::get('export', [UserManagementController::class, 'export'])->name('export');
        Route::post('import', [UserManagementController::class, 'import'])->name('import');
        Route::get('template', [UserManagementController::class, 'downloadTemplate'])->name('template');
        Route::get('export-pdf', [ExportPdfController::class, 'usersExportPdf'])->name('view-pdf');
    });

    Route::get('monitoring', [UserManagementController::class, 'monitoring'])->name('monitoring.index');
});

Route::middleware('auth')->group(function () {
    Route::post('/tanyas', [TanyaController::class, 'store'])->name('tanyas.store');
    Route::delete('/tanyas/{tanya}', [TanyaController::class, 'destroy'])->name('tanyas.destroy');
});

Route::prefix('admin/tanyas')->name('admin.tanyas.')->group(function () {
    Route::get('/', [TanyaController::class, 'index'])->name('index');
    Route::delete('/{tanya}', [TanyaController::class, 'adminDestroy'])->name('destroy');
})->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);

Route::middleware('auth')->group(function () {
    Route::post('/jawabs', [JawabController::class, 'store'])->name('jawabs.store');
    Route::get('/jawabs/{jawab}/edit', [JawabController::class, 'edit'])->name('jawabs.edit');
    Route::put('/jawabs/{jawab}', [JawabController::class, 'update'])->name('jawabs.update');
    Route::delete('/jawabs/{jawab}', [JawabController::class, 'destroy'])->name('jawabs.destroy');
});

Route::prefix('admin/moduls/{modul}/submoduls/{submodul}/quizzes')->name('admin.moduls.submoduls.quizzes.')->group(function () {
    Route::get('create', [QuizController::class, 'create'])->name('create');
    Route::post('/', [QuizController::class, 'store'])->name('store');
    Route::get('{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
    Route::put('{quiz}', [QuizController::class, 'update'])->name('update');
    Route::delete('{quiz}', [QuizController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->prefix('moduls/{modul}/submoduls/{sort_order}/quiz')->name('moduls.submoduls.quiz.')->group(function () {
    Route::get('/', [QuizController::class, 'show'])->name('show');
    Route::get('{quiz}/take', [QuizController::class, 'showQuiz'])->name('take');
    Route::post('submit', [QuizController::class, 'submit'])->name('submit');
    Route::get('{quiz}/result', [QuizController::class, 'result'])->name('result');
});
