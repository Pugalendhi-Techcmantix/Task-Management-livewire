<?php

use App\Http\Controllers\SampleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


// Route::middleware('api')->group(function () {
Route::group(['prefix' => 'api'], function () {
    Route::get('/students', [StudentController::class, 'getStudents']);
    Route::get('/student', [StudentController::class, 'getStudent']);
    Route::post('/students', [StudentController::class, 'createStudent']);
    Route::post('/student', [StudentController::class, 'deleteStudent']);
    Route::put('/student', [StudentController::class, 'updateStudent']);


    Route::post('/sample', [SampleController::class, "createUser"]);
    Route::get('/samples', [SampleController::class, "getUsers"]);
    Route::get('/sample', [SampleController::class, "getUser"]);
    Route::delete('/sample', [SampleController::class, "deleteUser"]);
    Route::put('/sample', [SampleController::class, "updateUser"]);
});
