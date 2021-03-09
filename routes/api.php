<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EventController;

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

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user-info', [AuthController::class, 'getUser']);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::get('user/{id}/kelas', [UserController::class, 'getKelas']);
    Route::get('user/{id}/task', [UserController::class, 'getTask']);
    Route::get('user/{id}/sent_task', [UserController::class, 'getSentTask']);
    Route::get('user/{id}/sent_event', [UserController::class, 'getSentEvent']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    
    Route::get('kelas', [KelasController::class, 'index']);
    Route::get('kelas/{id}', [KelasController::class, 'show']);
    Route::get('kelas/{id}/owner', [KelasController::class, 'getOwner']);
    Route::get('kelas/{id}/anggota', [KelasController::class, 'getAnggota']);
    Route::post('kelas', [KelasController::class, 'store']);
    Route::put('kelas/{id}', [KelasController::class, 'update']);
    Route::delete('kelas/{id}', [KelasController::class, 'destroy']);
    
    Route::get('task', [TaskController::class, 'index']);
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::get('task/{id}/owner', [TaskController::class, 'getOwner']);
    Route::get('task/{id}/kelas', [TaskController::class, 'getKelas']);
    Route::post('task', [TaskController::class, 'store']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{id}', [TaskController::class, 'destroy']);
    
    Route::get('event', [EventController::class, 'index']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::get('event/{id}/owner', [EventController::class, 'getOwner']);
    Route::get('event/{id}/kelas', [EventController::class, 'getKelas']);
    Route::post('event', [EventController::class, 'store']);
    Route::put('event/{id}', [EventController::class, 'update']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);
});