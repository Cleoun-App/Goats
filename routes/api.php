<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\GoatController;
use App\Http\Controllers\Api\MilkNoteController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\GroupController;
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
     *  Event APIs
     */
    
     Route::get('/event/type', [EventController::class, 'getEventType']);

     Route::get('/user/{username}/event/{event_id}/get', [EventController::class, 'getEvent']);

     Route::get('/user/{username}/events/get', [EventController::class, 'getEvents']);

     Route::post('/user/{username}/event/create', [EventController::class, 'addEvent']);

     Route::post('/user/{username}/event/{event_id}/update', [EventController::class, 'updateEvent']);

     Route::delete('user/{username}/event/{event_id}/delete', [EventController::class, 'deleteEvent']);
     
    /**
     *  End Event APIs
     */

    /**
    *   Group API  
    */

    Route::get('/user/groups', [GroupController::class, 'getGroups']);

    Route::post('/user/group/add', [GroupController::class, 'addGroup']);
    
    Route::post('/user/group/{group_id}/edit', [GroupController::class, 'editGroup']);
    
    Route::delete('/user/group/{group_id}/delete', [GroupController::class, 'deleteGroup']);


    /**
     *  Goat APIs
     */

    Route::get('/user/{username}/goat/{tag}/get', [GoatController::class, 'getGoat']);
    
    Route::get('/user/{username}/goats/get', [GoatController::class, 'getGoats']);
    
    Route::post('/user/{username}/goat/add', [GoatController::class, 'addGoat']);
    
    Route::post('/user/{username}/goat/{goat_tag}/update', [GoatController::class, 'updateGoat']);
    
    Route::delete('/user/{username}/goat/{tag}/delete', [GoatController::class, 'deleteGoat']);

    Route::get('/goat/breeds', [GoatController::class, 'getBreeds']);

    /**
     *  End Goat APIs
     */


    /**
     *  Milknote APIs
     */

    Route::get('user/{username}/notes/get', [MilkNoteController::class, 'getNotes']);

    Route::get('user/{username}/note/{id}/get', [MilkNoteController::class, 'getNote']);
    
    Route::post('user/{username}/note/add', [MilkNoteController::class, 'addNote']);
    
    Route::post('user/{username}/note/{id}/update', [MilkNoteController::class, 'updateNote']);
    
    Route::delete('user/{username}/note/{id}/delete', [MilkNoteController::class, 'deleteNote']);
    

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
