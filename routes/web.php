<?php


use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;


Route::get('/', function () {
    return view('auth.login');
})->middleware(['auth', 'verified'])->name('login');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/pending', function () {
//     return view('pending');
// })->name('pending');
// Route::get('/progress', function () {
//     return view('progress');
// })->name('progress');
// Route::get('/hold', function () {
//     return view('hold');
// })->name('hold');
// Route::get('/completed', function () {
//     return view('completed');
// })->name('completed');
// Route::get('/sample', function () {
//     return view('task-kanban-board');
// })->name('sample');

// Route::get('/support-page', function () {
//     return view('support-page');
// })->name('support-page');


Route::middleware('auth', RoleMiddleware::class)->group(function () {

    Route::get('employee-list', [EmployeeController::class, 'index'])->name('employee-list');
    Route::get('role-list', [RoleController::class, 'index'])->name('role-list');
    Route::get('task-list', [TaskController::class, 'index'])->name('task-list');
    Route::get('/support-list', function () {
        return view('support-list');
    })->name('support-list');
});


Route::middleware(['auth', RoleMiddleware::class])->group(function () {

    // User routes (These should only be accessed by users, not admins)
    Route::get('/pending', function () {
        return view('pending');
    })->name('pending');

    Route::get('/progress', function () {
        return view('progress');
    })->name('progress');

    Route::get('/hold', function () {
        return view('hold');
    })->name('hold');

    Route::get('/completed', function () {
        return view('completed');
    })->name('completed');

    Route::get('/sample', function () {
        return view('task-kanban-board');
    })->name('sample');

    Route::get('/support-page', function () {
        return view('support-page');
    })->name('support-page');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
