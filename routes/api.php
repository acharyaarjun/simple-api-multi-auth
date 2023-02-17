<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::prefix('user')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::middleware('user')->group(function () {
            Route::get('/me', function () {
                dd('yeha aayo normal login user vayera');
            });
        });
    });
});

Route::prefix('doctor')->group(function () {
    Route::post('register', [AuthController::class, 'doctorRegister']);

    Route::middleware('auth:api')->group(function () {
        Route::middleware('doctor')->group(function () {
            Route::get('/me', function () {
                dd('yeha aayo doctor vayera');
            });
        });
    });
});


Route::prefix('admin')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::get('/me', function () {
                dd('yeha aayo admin vayera');
            });
        });
    });
});
