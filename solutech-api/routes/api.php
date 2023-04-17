<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('status')->group(function (){
    Route::get('/',[StatusController::class,'index']);
    Route::post('/',[StatusController::class,'create']);
    Route::patch('/{id}',[StatusController::class,'update']);
    Route::delete('/{id}',[StatusController::class,'destroy']);
});

Route::prefix('tasks')->group(function (){
    Route::get('/',[TaskController::class,'index']);
    Route::post('/',[TaskController::class,'create']);
    Route::patch('/{id}',[TaskController::class,'update']);
    Route::delete('/{id}',[TaskController::class,'destroy']);
});
