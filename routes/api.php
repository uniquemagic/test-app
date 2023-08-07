<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;

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

Route::prefix('user')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('{id}', 'show');
        Route::get('{id}/projects', 'projects');
    }
);

Route::prefix('projects')
    ->controller(ProjectController::class)
    ->group(function () {

        Route::get('{id}', 'show');
        Route::get('{id}/simple-tasks-list', 'simpleTasksList');

        Route::post('', 'store');
        Route::post('{id}/tasks', 'storeTask');

        Route::put('{id}', 'update');
        Route::put('{id}/tasks/{task_id}', 'updateTask');

        Route::delete('{id}', 'destroy');
        Route::delete('{id}/tasks/{task_id}', 'destroyTask');
    }
);