<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



 // ROUTE USER
 Route::post('login', [AuthController::class,'login'])->name('login');
 Route::post('register', [AuthController::class,'register'])->name('register');

 // ROUTE TASK
 Route::middleware('jwt')->group(function () {

    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    Route::post('tasks', [TaskController::class, 'create'])->name('create');
    Route::get('tasks', [TaskController::class, 'index'])->name('index');
    Route::get('tasks/{id}', [TaskController::class, 'show'])->name('show');
    Route::put('tasks/{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('tasks/{id}', [TaskController::class, 'destroy'])->name('destroy');
    Route::fallback([TaskController::class,'notFound'])->name('notFound');

});









