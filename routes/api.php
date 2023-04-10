<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SeatController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('trips', [TripController::class, 'index']);
Route::get('stations', [StationController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('seats/list/{trip}', [SeatController::class, 'listAvailableSeats']);
    Route::post('seats/book', [SeatController::class, 'book']);
});
