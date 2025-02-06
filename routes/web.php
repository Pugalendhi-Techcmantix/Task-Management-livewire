<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', [CommonController::class, 'login'])->middleware(['auth'])->name('login');

// Route::get('/', [CommonController::class, 'dashboard'])->middleware(['auth', 'verified']);
Route::get('dashboard', [CommonController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('chat-box', [CommonController::class, 'chat_box'])->middleware(['auth'])->name('chat-box');
Route::middleware('auth', RoleMiddleware::class)->group(function () {
    Route::get('employee-list', [AdminController::class, 'employee_list'])->name('employee-list');
    Route::get('role-list', [AdminController::class, 'role_list'])->name('role-list');
    Route::get('task-list', [AdminController::class, 'task_list'])->name('task-list');
    Route::get('support-list', [AdminController::class, 'support_list'])->name('support-list');
});


Route::middleware(['auth', RoleMiddleware::class])->group(function () {
    Route::get('pending', [UserController::class, 'pending'])->name('pending');
    Route::get('progress', [UserController::class, 'progress'])->name('progress');
    Route::get('hold', [UserController::class, 'hold'])->name('hold');
    Route::get('completed', [UserController::class, 'completed'])->name('completed');
    Route::get('support-page', [UserController::class, 'support_page'])->name('support-page');
    Route::get('sample', [UserController::class, 'sample'])->name('sample');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
