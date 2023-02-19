<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Members\FamilyHouseMembersController;
use App\Http\Controllers\Members\FamilyHousesController;
use App\Http\Controllers\Members\FamilyMembersController;
use App\Http\Controllers\Shares\FamilySharesContributionsController;
use App\Http\Controllers\Shares\FamilySharesTypeController;
use App\Http\Controllers\Shares\Savings\FamilySharesSavingsController;
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

Route::prefix('family')->group(function () {

    Route::prefix('members')->group(function () {

        Route::post('create', [FamilyMembersController::class, 'create']);

        Route::get('list', [FamilyMembersController::class, 'listMembers']);

        Route::put('update/{id}', [FamilyMembersController::class, 'updateMembers']);
    });

    Route::prefix("houses")->group(function () {

        Route::post("create", [FamilyHousesController::class, 'createFamilyHouse']);

        Route::get("list", [FamilyHousesController::class, 'listFamilyHouses']);

        Route::put("update/{id}", [FamilyHousesController::class, "updateFamilyHouses"]);

        Route::prefix("members")->group(function () {

            Route::post("create-members", [FamilyHouseMembersController::class, "createFamilyHouseMembers"]);

            Route::get("list-members", [FamilyHouseMembersController::class, "listFamilyHouseMembers"]);
        });
    });

    Route::prefix("shares")->group(function () {

        Route::post("", [FamilySharesTypeController::class, "recordSharesType"]);

        Route::get("", [FamilySharesTypeController::class, "listShareTypes"]);

        Route::put("update/{id}", [FamilySharesTypeController::class, "updateSharesType"])->whereNumber("id");

        Route::delete("delete/{id}", [FamilySharesTypeController::class, "deleteShareType"])->whereNumber("id");

        Route::post("contributions/create", [FamilySharesContributionsController::class, "createFamilySharesContributions"]);

        Route::get("contributions/list", [FamilySharesContributionsController::class, "listFamilySharesContributions"]);

        Route::put("contributions/update/{contributionID}", [FamilySharesContributionsController::class, "updateFamilySharesContributions"])->whereNumber("contributionID");

        Route::get("savings", [FamilySharesSavingsController::class, "listSavingsShare"]);

        Route::post("savings/create", [FamilySharesSavingsController::class, "recordSavings"]);

        Route::put("savings/update/{savingID}", [FamilySharesSavingsController::class, "updateSavings"])->whereNumber("savingID");

        Route::get("savings-transactions", [FamilySharesSavingsController::class, "listSavingsTransactions"]);

        Route::post("savings-transactions", [FamilySharesSavingsController::class, "createSavingsTransactions"]);
    });
});
