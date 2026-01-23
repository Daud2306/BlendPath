<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TutorialController;
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

Route::middleware('auth')->prefix('roadmaps')->name('roadmaps.')->group(function () {
    Route::get('/', [RoadmapController::class, 'index'])->name('index');
    Route::get('{roadmap}/tutorials', [RoadmapController::class, 'show'])->name('show');
    Route::get('{roadmap}/tutorials/{sort_order}', [TutorialController::class, 'userShow'])->name('tutorials.show');

    Route::post('{roadmap}/tutorials/{sort_order}/complete', [ProgressController::class, 'markAsCompleted'])
        ->name('tutorials.complete');
    Route::post('{roadmap}/tutorials/{sort_order}/incomplete', [ProgressController::class, 'markAsIncomplete'])
        ->name('tutorials.incomplete');
});

Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('search', [AdminSearchController::class, 'search'])->name('search');

    Route::prefix('roadmaps')->name('roadmaps.')->group(function () {
        Route::get('/', [RoadmapController::class, 'adminIndex'])->name('index');
        Route::get('create', [RoadmapController::class, 'create'])->name('create');
        Route::post('/', [RoadmapController::class, 'store'])->name('store');
        Route::get('{roadmap}/edit', [RoadmapController::class, 'edit'])->name('edit');
        Route::put('{roadmap}', [RoadmapController::class, 'update'])->name('update');
        Route::delete('{roadmap}', [RoadmapController::class, 'destroy'])->name('destroy');

        Route::post('{roadmap}/tutorials/{tutorial}/resources', [TutorialController::class, 'updateResources'])
            ->name('tutorials.resources.store');
        Route::delete('{roadmap}/tutorials/{tutorial}/resources/{resource}', [TutorialController::class, 'destroyResource'])
            ->name('tutorials.resources.destroy');

        Route::get('{roadmap}/tutorials', [RoadmapController::class, 'adminShow'])->name('tutorials.index');
        Route::get('{roadmap}/tutorials/create', [TutorialController::class, 'create'])->name('tutorials.create');
        Route::post('{roadmap}/tutorials', [TutorialController::class, 'store'])->name('tutorials.store');
        Route::get('{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'adminShow'])->name('tutorials.show');
        Route::get('{roadmap}/tutorials/{tutorial}/edit', [TutorialController::class, 'edit'])->name('tutorials.edit');
        Route::put('{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'update'])->name('tutorials.update');
        Route::delete('{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'destroy'])->name('tutorials.destroy');
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

Route::prefix('admin/roadmaps/{roadmap}/tutorials/{tutorial}/quizzes')->name('admin.roadmaps.tutorials.quizzes.')->group(function () {
    Route::get('create', [QuizController::class, 'create'])->name('create');
    Route::post('/', [QuizController::class, 'store'])->name('store');
    Route::get('{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
    Route::put('{quiz}', [QuizController::class, 'update'])->name('update');
    Route::delete('{quiz}', [QuizController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->prefix('roadmaps/{roadmap}/tutorials/{sort_order}/quiz')->name('roadmaps.tutorials.quiz.')->group(function () {
    Route::get('/', [QuizController::class, 'show'])->name('show');
    Route::get('{quiz}/take', [QuizController::class, 'showQuiz'])->name('take');
    Route::post('submit', [QuizController::class, 'submit'])->name('submit');
    Route::get('{quiz}/result', [QuizController::class, 'result'])->name('result');
});
