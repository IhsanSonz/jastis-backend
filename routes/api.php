<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventCommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user-info', [AuthController::class, 'getUser']);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::get('user/{id}/owned', [UserController::class, 'getOwned']);
    Route::get('user/{id}/kelas', [UserController::class, 'getKelas']);
    Route::post('user/{id}/kelas', [UserController::class, 'connectKelas']);
    Route::delete('user/{id}/kelas', [UserController::class, 'disconnectKelas']);
    Route::get('user/{id}/task', [UserController::class, 'getTask']);
    Route::get('user/{id}/sent_task', [UserController::class, 'getSentTask']);
    Route::get('user/{id}/find_st', [UserController::class, 'findSentTask']);
    Route::post('user/{id}/sent_task', [UserController::class, 'sendTask']);
    Route::put('user/{id}/sent_task', [UserController::class, 'updateTask']);
    Route::get('user/{id}/event', [UserController::class, 'getEvent']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);

    Route::get('kelas', [KelasController::class, 'index']);
    Route::get('kelas/{id}', [KelasController::class, 'show']);
    Route::get('kelas/{id}/owner', [KelasController::class, 'getOwner']);
    Route::get('kelas/{id}/anggota', [KelasController::class, 'getAnggota']);
    Route::get('kelas/{id}/task', [KelasController::class, 'getTask']);
    Route::get('kelas/{id}/event', [KelasController::class, 'getEvent']);
    Route::post('kelas', [KelasController::class, 'store']);
    Route::put('kelas/{id}', [KelasController::class, 'update']);
    Route::delete('kelas/{id}', [KelasController::class, 'destroy']);

    Route::get('task', [TaskController::class, 'index']);
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::get('task/{id}/owner', [TaskController::class, 'getOwner']);
    Route::get('task/{id}/kelas', [TaskController::class, 'getKelas']);
    Route::get('task/{id}/sent', [TaskController::class, 'getSentTask']);
    Route::post('task', [TaskController::class, 'store']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{id}', [TaskController::class, 'destroy']);
    Route::post('task/{id}/score', [TaskController::class, 'setScore']);
    Route::put('task/{id}/score', [TaskController::class, 'updateScore']);

    Route::get('event', [EventController::class, 'index']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::get('event/{id}/owner', [EventController::class, 'getOwner']);
    Route::get('event/{id}/kelas', [EventController::class, 'getKelas']);
    Route::post('event', [EventController::class, 'store']);
    Route::put('event/{id}', [EventController::class, 'update']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);

    Route::get('task_comment', [TaskCommentController::class, 'index']);
    Route::get('task_comment/{id}', [TaskCommentController::class, 'show']);
    Route::get('task_comment/{id}/user', [TaskCommentController::class, 'getUser']);
    Route::get('task_comment/{id}/task', [TaskCommentController::class, 'getTask']);
    Route::post('task_comment', [TaskCommentController::class, 'store']);
    Route::put('task_comment/{id}', [TaskCommentController::class, 'update']);
    Route::delete('task_comment/{id}', [TaskCommentController::class, 'destroy']);

    Route::get('event_comment', [EventCommentController::class, 'index']);
    Route::get('event_comment/{id}', [EventCommentController::class, 'show']);
    Route::get('event_comment/{id}/user', [EventCommentController::class, 'getUser']);
    Route::get('event_comment/{id}/event', [EventCommentController::class, 'getEvent']);
    Route::post('event_comment', [EventCommentController::class, 'store']);
    Route::put('event_comment/{id}', [EventCommentController::class, 'update']);
    Route::delete('event_comment/{id}', [EventCommentController::class, 'destroy']);

    // test drive fcm
    Route::post('notif', [UserController::class, 'notif']);
});
