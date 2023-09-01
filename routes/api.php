<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;

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

Route::post("login",[UserController::class,"login"]);

Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('add', [UserController::class, 'add']);
    });

    Route::prefix('team')->group(function () {
        Route::post('add', [TeamController::class, 'add']);
    });

    Route::prefix('project')->group(function () {
        Route::post('add', [ProjectController::class, 'add']);
        Route::post('assign', [ProjectController::class, 'assign']);
    });
    
});

Route::get("test",function(Request $request){
  return "Hi email";
});


Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();
});
