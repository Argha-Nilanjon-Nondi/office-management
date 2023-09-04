<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AssignmentController;
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

Route::post("login", [UserController::class, "login"]);

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

  Route::prefix('user')->group(function () {
    Route::post('add', [UserController::class, 'add']);
    Route::post('assign', [TeamController::class, 'assign']);
  });

});

Route::prefix('boss')->middleware(['auth:sanctum', 'role:boss'])->group(function () {

  Route::prefix('team')->group(function () {
    Route::get('/', [TeamController::class, 'team_list']);
    Route::get('/{team_id}', [TeamController::class, 'single_team']);
    Route::post('/add', [TeamController::class, 'add']);
    Route::post('/{team_id}/assign', [TeamController::class, 'assign']);
  });

  Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'project_list']);
    Route::get("/{project_id}",[ProjectController::class,"single_project"]);
    Route::post('/add', [ProjectController::class, 'add']);
    Route::post('/{project_id}/assign', [ProjectController::class, 'assign']);
  });

});


Route::prefix('project_manager')->middleware(['auth:sanctum', 'role:project_manager'])->group(function () {

  Route::prefix('project')->group(function () {
    Route::prefix('log')->group(function () {
      Route::get('/{project_id}', [ProjectController::class, 'project_log_list']);
      Route::post('/{team_id}/{project_id}/add', [ProjectController::class, 'add_log']);
    });
  });
  
  Route::prefix('assignment')->group(function () {
    Route::post('/{team_id}/{project_id}/add', [AssignmentController::class, 'add']);
  });

});



/*
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

  Route::prefix('user')->group(function () {
    Route::post('add', [UserController::class, 'add']);
    Route::post('assign', [TeamController::class, 'assign']);
  });

  Route::prefix('team')->group(function () {
    Route::post('add', [TeamController::class, 'add']);
    Route::post('assign', [TeamController::class, 'assign']);
  });

  Route::prefix('project')->group(function () {
    Route::post('add', [ProjectController::class, 'add']);
    Route::post('assign', [ProjectController::class, 'assign']);
    Route::prefix('log')->group(function () {
      Route::post('add', [ProjectController::class, 'add_log']);
    });


  });
  Route::prefix('assignment')->group(function () {
    Route::post('add', [AssignmentController::class, 'add']);
  });


});

*/


Route::get("test", function(Request $request) {
  return "Hi email";
});


Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
  return $request->user();
});