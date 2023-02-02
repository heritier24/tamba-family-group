<?php

use App\Http\Controllers\AuthenticationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('authentication')->group(function () {

    Route::post('login', [AuthenticationController::class, 'login']);

    Route::get('forgot-password', [AuthenticationController::class, 'forgotPassword']);

    Route::put('reset-password', [AuthenticationController::class, 'resetPassword']);

    Route::get('logout', [AuthenticationController::class, 'logout']);
});
