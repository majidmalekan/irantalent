<?php

use App\Http\Controllers\api\v1\PositionController;
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

Route::prefix('v1')->group(function () {
    Route::apiResource('position', PositionController::class);
    Route::prefix('positions')->group(function () {
        Route::get('search', [PositionController::class, "search"]);
    });
});
