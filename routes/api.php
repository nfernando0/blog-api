<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function () {
    Route::get('/user', [App\Http\Controllers\UserController::class, 'getUser']);
    Route::patch('/user/update', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/logout', [App\Http\Controllers\UserController::class, 'logout']);
});
