<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoadmapUserController;
use App\Http\Controllers\RoadmapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.index');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});

// Route::resource('users', UserController::class);

Route::get('/login', function () {
    return view('user.auth.login');
});

Route::get('/register', function () {
    return view('user.auth.register');
});

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

Route::prefix('roadmaps')->group(function () {
    Route::view('/', 'user.roadmaps.index');
    Route::view('/{roadmap}', 'user.roadmaps.detail');
    Route::view('/{roadmap}/tutorials', 'user.tutorials.index');
    Route::view('/{roadmap}/tutorials/{tutorial}', 'user.tutorials.show')->name('tutorials.show');
});

Route::prefix('admin/roadmaps')->group(function () {
    Route::view('/', 'admin.roadmaps.index');
    Route::view('/create', 'admin.roadmaps.create');
    Route::view('/{roadmap}', 'admin.roadmaps.show');
    Route::view('/{roadmap}/tutorials', 'admin.tutorials.index');
    Route::view('/{roadmap}/tutorials/{tutorial}', 'admin.tutorials.show');
});

Route::prefix('admin/users')->group(function () {
    Route::view('/', 'admin.users.index');
    Route::view('/{user}', 'admin.users.show');
    Route::view('/{user}/edit', 'admin.users.edit');
});

Route::view('admin/qna', 'admin.qna.index')->name('admin.qna.index');
Route::view('admin/qna/{question}', 'admin.qna.show')->name('admin.qna.show');

Route::view('/admin/resource', 'admin.media.index')->name('media.index');
Route::view('/admin/{resource}', 'admin.media.show')->name('media.show');

Route::view('/about', 'user.about')->name('about');

Route::prefix('admin/tutorials')->group(function () {
    Route::view('/create', 'admin.tutorials.create');
    Route::view('/tutorials/{tutorial}/edit', 'admin.tutorials.edit');
});
