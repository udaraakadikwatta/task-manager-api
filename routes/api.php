<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Task\ListTasksController;
use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\UpdateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\CompleteTaskController;

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
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:api')->group(function(){
   Route::get('/tasks', ListTasksController::class);
   Route::post('/tasks', CreateTaskController::class);
   Route::put('/tasks/{task}', UpdateTaskController::class);
   Route::delete('/tasks/{task}', DeleteTaskController::class);
   Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
});
