<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
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



Route::prefix('auth')->group(function (){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::middleware(['auth:api'])->group(function ($router){

    Route::prefix('status')->group(function (){
        Route::get('/',[StatusController::class,'get_statuses']);
        Route::get('/{id}',[StatusController::class,'get_status']);
        Route::post('/',[StatusController::class,'create_status']);
        Route::patch('/{id}',[StatusController::class,'update']);
        Route::delete('/{id}',[StatusController::class,'destroy_status']);
    });

    Route::prefix('tasks')->group(function (){
        Route::get('/',[TaskController::class, 'get_tasks']);
        Route::get('/{id}',[TaskController::class,'get_task']);
        Route::post('/',[TaskController::class,'create_task']);
        Route::patch('/{id}',[TaskController::class, 'update_task']);
        Route::delete('/{id}',[TaskController::class,'destroy_task']);

        Route::prefix('user')->group(function (){
            Route::get('/',[UsersController::class, 'get_users_tasks']);
            Route::get('/{id}',[UsersController::class, 'get_user_tasks']);
            Route::get('/task/{id}',[UsersController::class,'get_one_user_task']);
            Route::post('/',[UsersController::class,'create_user_task']);
            Route::patch('/{id}',[UsersController::class,'update_user_task']);
            Route::delete('/{id}',[UsersController::class,'destroy_user_task']);
        });
    });
});


