<?php


use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('student-list', [StudentController::class, 'viewList'])->name('student-list');
Route::get('student-add', [StudentController::class, 'viewForm'])->name("student-add");
Route::get('student-edit/{id}', [StudentController::class, 'editForm'])->name("student-edit");

Route::get('employee-list', [EmployeeController::class, 'index'])
    ->middleware(['auth'])->name('employee-list');
Route::get('role-list', [RoleController::class, 'index'])
    ->middleware(['auth'])->name('role-list');
Route::get('task-list', [TaskController::class, 'index'])
    ->middleware(['auth'])
    ->name('task-list');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
