<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Jobs\QueueEmailPassword;

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
   // Route::get('/', [UserController::class, 'index']);  // Admin Dashboard

    Route::prefix('user')->group(function () {
        Route::post('add', [UserController::class, 'add']); // Create user
        //Route::post('/{id}', [UserController::class, 'update']); // Update user
    });
/*
    Route::prefix('team')->group(function () {
        Route::post('/', [TeamController::class, 'store']); // Create team
        Route::post('/{id}', [TeamController::class, 'update']); // Update team
    });

    Route::prefix('project')->group(function () {
        Route::post('/', [ProjectController::class, 'store']); // Create project
        Route::post('/{id}', [ProjectController::class, 'update']); // Update project
    });
    */
    
});

Route::get("test",function(Request $request){
  $username="username";
  $password="password";
  $email="example@jio.com";
  dispatch(new QueueEmailPassword($email,$username,$password));
  return "Hi email";
});


Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();
});
