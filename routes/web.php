<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// ─── User Controllers ────────────────────────────────────────────────────────
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\SubmodulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TanyaController;
use App\Http\Controllers\JawabController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TinyMCEController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\ProfileController;

// ─── Admin Controllers ───────────────────────────────────────────────────────
use App\Http\Controllers\Admin\ModulController      as AdminModulController;
use App\Http\Controllers\Admin\SubmodulController   as AdminSubmodulController;
use App\Http\Controllers\Admin\QuizController       as AdminQuizController;
use App\Http\Controllers\Admin\TanyaController      as AdminTanyaController;
use App\Http\Controllers\Admin\JawabController      as AdminJawabController;
use App\Http\Controllers\Admin\UserController       as AdminUserController;
use App\Http\Controllers\Admin\SearchController     as AdminSearchController;
use App\Http\Controllers\Admin\ExportPdfController  as AdminExportPdfController;
use App\Http\Controllers\Admin\DashboardController  as AdminDashboardController;
use App\Http\Controllers\Admin\ShowcaseController   as AdminShowcaseController;
use App\Http\Controllers\Admin\DiskusiController    as AdminDiskusiController;
use App\Http\Controllers\MiniProjectController;

// =============================================================================
// Auth
// =============================================================================

Route::get('/', [AuthController::class, 'home'])->name('home');
Route::view('/about', 'user.about');

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/register',  'showRegisterForm')->name('register');
        Route::post('/register', 'register')->name('register.process');
        Route::get('/login',     'showLoginForm')->name('login');
        Route::post('/login',    'login')->name('login.process');
    });
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('auth.google.callback');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');
});

Route::middleware(['auth'])
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/',      [ProfileController::class, 'show'])->name('show');
        Route::get('/edit',  [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/',    [ProfileController::class, 'update'])->name('update');
        Route::delete('/',   [ProfileController::class, 'destroy'])->name('destroy');
    });

// =============================================================================
// User — /learn
// =============================================================================

Route::middleware(['auth', 'role:user'])
    ->prefix('learn')
    ->name('learn.')
    ->group(function () {

        // Modul
        Route::get('moduls',          [ModulController::class, 'index'])->name('moduls.index');
        Route::get('moduls/{modul}',   [ModulController::class, 'show'])->name('moduls.show');

        // Submodul
        Route::get(
            'moduls/{modul}/submoduls/{sort_order}',
            [SubmodulController::class, 'show']
        )->name('submoduls.show');

        // Progress
        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/complete',
            [ProgressController::class, 'markAsCompleted']
        )->name('submoduls.complete');

        Route::post(
            'moduls/{modul}/submoduls/{sort_order}/incomplete',
            [ProgressController::class, 'markAsIncomplete']
        )->name('submoduls.incomplete');

        // Quiz
        Route::prefix('moduls/{modul}/submoduls/{submodul}')->name('quizzes.')->group(function () {
            Route::get('quiz/{quiz}',                  [QuizController::class, 'take'])->name('take');
            Route::post('quiz/{quiz}/submit',          [QuizController::class, 'submit'])->name('submit');
            Route::get('quiz/{quiz}/result/{attempt}', [QuizController::class, 'result'])->name('result');
        });

        Route::post('mini-projects/{miniProject}/submit', [MiniProjectController::class, 'store'])->name('mini_projects.submit');
        Route::delete('mini-projects/{miniProject}/resubmit', [MiniProjectController::class, 'resubmit'])->name('mini_projects.resubmit');

        // Tanya & Jawab
        Route::resource('tanyas', TanyaController::class)->only(['store', 'edit', 'update', 'destroy']);
        Route::resource('jawabs', JawabController::class)->only(['store', 'edit', 'update', 'destroy']);

        // TinyMCE
        Route::prefix('tinymce')->group(function () {
            Route::post('upload',       [TinyMCEController::class, 'upload']);
            Route::delete('media/{id}', [TinyMCEController::class, 'delete']);
            Route::get('list',          [TinyMCEController::class, 'index']);
        });

        // Showcase (user)
        Route::prefix('showcase')->name('showcase.')->group(function () {
            Route::get('/',              [ShowcaseController::class, 'index'])->name('index');
            Route::get('/create',        [ShowcaseController::class, 'create'])->name('create');
            Route::post('/',             [ShowcaseController::class, 'store'])->name('store');
            Route::get('/{showcase}',    [ShowcaseController::class, 'show'])->name('show');
            Route::delete('/{showcase}', [ShowcaseController::class, 'destroy'])->name('destroy');

            Route::post('/{showcase}/komentar',   [ShowcaseController::class, 'storeKomentar'])->name('komentar.store');
            Route::delete('/komentar/{komentar}', [ShowcaseController::class, 'destroyKomentar'])->name('komentar.destroy');
        });
    });

// =============================================================================
// Admin — /admin
// =============================================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('search',    [AdminSearchController::class,    'search'])->name('search');

        // Modul
        Route::resource('moduls', AdminModulController::class)->names('moduls');

        // Submodul
        Route::resource('moduls.submoduls', AdminSubmodulController::class)->names('moduls.submoduls');

        // Quiz
        Route::resource('moduls.submoduls.quiz', AdminQuizController::class)
            ->except(['index'])
            ->parameter('quiz', 'quiz')
            ->names('moduls.submoduls.quiz');

        Route::put('mini-projects/submission/{submission}', [App\Http\Controllers\Admin\MiniProjectController::class, 'updateStatus'])
            ->name('mini_projects.update_status');

        // Users
        Route::resource('users', AdminUserController::class)->except(['show'])->names('users');
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('export',     [AdminUserController::class,      'export'])->name('export');
            Route::post('import',    [AdminUserController::class,      'import'])->name('import');
            Route::get('template',   [AdminUserController::class,      'downloadTemplate'])->name('template');
            Route::get('export-pdf', [AdminExportPdfController::class, 'usersExportPdf'])->name('view-pdf');
        });

        Route::get('monitoring', [AdminUserController::class, 'monitoring'])->name('monitoring.index');

        // Tanya & Jawab (lama — dipertahankan untuk kompatibilitas)
        Route::resource('tanyas', AdminTanyaController::class)->only(['index', 'destroy'])->names('tanyas');
        Route::resource('jawabs', AdminJawabController::class)->only(['index', 'destroy'])->names('jawabs');

        // Diskusi — halaman baru: thread view (tanya + jawab dalam satu halaman)
        Route::prefix('diskusi')->name('diskusi.')->group(function () {
            Route::get('/',               [AdminDiskusiController::class, 'index'])->name('index');
            Route::get('/{tanya}',        [AdminDiskusiController::class, 'show'])->name('show');
            Route::delete('/tanya/{tanya}', [AdminDiskusiController::class, 'destroyTanya'])->name('tanya.destroy');
            Route::delete('/jawab/{jawab}', [AdminDiskusiController::class, 'destroyJawab'])->name('jawab.destroy');
        });

        // Showcase (admin — moderasi)
        Route::prefix('showcase')->name('showcase.')->group(function () {
            Route::get('/',              [AdminShowcaseController::class, 'index'])->name('index');
            Route::get('/{showcase}',    [AdminShowcaseController::class, 'show'])->name('show');
            Route::delete('/{showcase}', [AdminShowcaseController::class, 'destroy'])->name('destroy');
            Route::delete('/komentar/{komentar}', [AdminShowcaseController::class, 'destroyKomentar'])->name('komentar.destroy');
        });

        // Course Builder
        Route::get('course-builder', [AdminModulController::class, 'builder'])->name('course.builder');
        Route::post('course-builder/reorder',                    [AdminModulController::class, 'reorder'])->name('course.builder.reorder');
        Route::post('course-builder/submodul/store',             [AdminModulController::class, 'builderStoreSubmodul'])->name('course.builder.submodul.store');
        Route::delete('course-builder/submodul/{submodul}',      [AdminModulController::class, 'builderDestroySubmodul'])->name('course.builder.submodul.destroy');
        Route::post('course-builder/quiz/store',                 [AdminModulController::class, 'builderStoreQuiz'])->name('course.builder.quiz.store');
        Route::delete('course-builder/quiz/{quiz}',              [AdminModulController::class, 'builderDestroyQuiz'])->name('course.builder.quiz.destroy');
        Route::post('course-builder/project/store',              [AdminModulController::class, 'builderStoreMiniProject'])->name('course.builder.project.store');
        Route::delete('course-builder/project/{miniProject}',    [AdminModulController::class, 'builderDestroyMiniProject'])->name('course.builder.project.destroy');
        Route::post('course-builder/submodul-video',             [AdminModulController::class, 'storeSubmodulVideo'])->name('course.builder.submodul.video');
        Route::delete('course-builder/resource/{resource}',      [AdminModulController::class, 'deleteResource'])->name('course.builder.resource.destroy');
    });

// =============================================================================
// Storage
// =============================================================================

Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    abort_unless(File::exists($fullPath), 404);
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');
