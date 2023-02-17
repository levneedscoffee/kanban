<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// ПОМЕНЯТЬ НА Route::resource
// Проверка прав
// регистрация через соц сети
//


Route::prefix('users')->group(function () {
    Route::controller(\App\Http\Controllers\Api\V1\UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');;
    });
});


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::controller(\App\Http\Controllers\Api\V1\KanbanController::class)->group(function () {
        Route::get('/{id}', 'show')->whereNumber('id');
    });

    Route::prefix('boards')->group(function () {
        Route::controller(\App\Http\Controllers\Api\V1\BoardsController::class)->group(function () {
            Route::get('/', 'store');
            Route::get('/{id}', 'show')->whereNumber('id')->middleware('check.rights');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'delete')->whereNumber('id');
            Route::post('/', 'create');
        });
    });


    Route::prefix('columns')->group(function () {
        Route::controller(\App\Http\Controllers\Api\V1\ColumnsController::class)->group(function () {
            Route::get('/', 'store');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'delete')->whereNumber('id');
            Route::post('/', 'create');
        });
    });


    Route::prefix('tasks')->group(function () {
        Route::controller(\App\Http\Controllers\Api\V1\TasksController::class)->group(function () {
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'delete')->whereNumber('id');
            Route::post('/', 'create');
        });
    });
});


