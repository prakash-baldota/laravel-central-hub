<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Version 1 API collections
Route::prefix('v1')->group(function () {
    Route::post('/authenticate', [AuthController::class, 'authenticate']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::middleware('auth:sanctum')->group( function () {
        Route::resource('users', UserController::class);
    });
});
