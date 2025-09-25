<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TutorialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.index');
});

// Route::resource('users', UserController::class);

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});

// Route::resource('users', UserController::class);
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process')
    ->middleware('guest');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process')
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// Route::get('/roadmap', function () {
//     return view('admin.roadmap');
// });

// Route::resource('users', UserController::class);

// // PUBLIC (hanya bisa melihat)
// Route::resource('roadmaps', RoadmapController::class)
//     ->only(['index', 'show']);

// // ADMIN (full CRUD)
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', function () {
//         return view('admin.dashboard');
//     })->name('dashboard');

//     Route::resource('roadmaps', RoadmapController::class);
// });

// Route::resource('roadmaps', RoadmapUserController::class);

Route::get('roadmaps', [RoadmapController::class, 'index'])->name('roadmaps.index');

Route::get('roadmaps/{roadmap}/tutorials', [RoadmapController::class, 'show'])->name('roadmaps.show');

Route::get('roadmaps/{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'userShow'])
    ->name('roadmaps.tutorials.show');

Route::prefix('admin/roadmaps')
    ->name('admin.roadmaps.')
    // ->middleware(['auth','can:manage-roadmaps'])
    ->group(function () {
        Route::get('/', [RoadmapController::class, 'adminIndex'])->name('index');
        Route::get('/create', [RoadmapController::class, 'create'])->name('create');
        Route::post('/', [RoadmapController::class, 'store'])->name('store');
        Route::get('/{roadmap}/tutorials', [RoadmapController::class, 'adminShow'])->name('show');
        Route::get('/{roadmap}/edit', [RoadmapController::class, 'edit'])->name('edit');
        Route::put('/{roadmap}', [RoadmapController::class, 'update'])->name('update');
        Route::delete('/{roadmap}/tutorials', [RoadmapController::class, 'destroy'])->name('destroy');

        Route::get('/{roadmap}/tutorials', [TutorialController::class, 'adminIndex'])->name('tutorials.index');
        Route::get('/{roadmap}/tutorials/create', [TutorialController::class, 'create'])->name('tutorials.create');
        Route::post('/{roadmap}/tutorials', [TutorialController::class, 'store'])->name('tutorials.store');
        Route::get('/{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'adminShow'])->name('tutorials.show');
        Route::get('/{roadmap}/tutorials/{tutorial}/edit', [TutorialController::class, 'edit'])->name('tutorials.edit');
        Route::put('/{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'update'])->name('tutorials.update');
        Route::delete('/{roadmap}/tutorials/{tutorial}', [TutorialController::class, 'destroy'])->name('tutorials.destroy');
    });
// Route::prefix('admin/users')->group(function () {
//     Route::view('/', 'admin.users.index');
//     Route::view('/{user}', 'admin.users.show');
//     Route::view('/{user}/edit', 'admin.users.edit');
// });

// Route::view('admin/qna', 'admin.qna.index')->name('admin.qna.index');
// Route::view('admin/qna/{question}', 'admin.qna.show')->name('admin.qna.show');

// Route::view('/admin/resource', 'admin.media.index')->name('media.index');
// Route::view('/admin/{resource}', 'admin.media.show')->name('media.show');

// Route::view('/about', 'user.about')->name('about');

// Route::prefix('admin/tutorials')->group(function () {
//     Route::view('/create', 'admin.tutorials.create');
//     Route::view('/tutorials/{tutorial}/edit', 'admin.tutorials.edit');
// });
