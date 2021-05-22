<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AuthController;

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

Route::Post("auth/register",[AuthController::class,'register']);
Route::Post("auth/login",[AuthController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::Get('auth/me',[AuthController::class,'getMe']);
    Route::Post('auth/change_password',[AuthController::class,'changePassword']);
});

Route::resource('posts', PostController::class);