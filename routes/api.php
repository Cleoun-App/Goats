<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoatController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->group(function () {

    /**
     *  Goat API
     */

    Route::get('/user/{username}/goats/get', [GoatController::class, 'getGoats']);

    /**
     *  User API
     */

    Route::get('/user/{username}', [UserController::class, 'getUser']);

    Route::delete('/user/{id}/delete', [UserController::class, 'deleteUser']);

    Route::post('/user/{username}/update', [UserController::class, 'editUser']);

    Route::get('/user/{username}/notifications', [NotificationController::class, 'getNotifications']);

    /**
     *  End User API
     */
});


Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/auth/registration', [AuthController::class, 'register']);

Route::post('/auth/forgot-password', [AuthController::class, 'forgot_password']);

Route::post('/auth/change-password', [AuthController::class, 'change_password'])->middleware('auth:sanctum');
