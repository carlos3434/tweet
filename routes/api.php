<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;

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
Route::post('register', [AuthController::class, 'register'] );
Route::post('login', [AuthController::class, 'login'] );
Route::get('unauthorized', [AuthController::class, 'unauthorized'] );

Route::group(['middleware' => 'auth_passport:sanctum'], function(){

     Route::apiResources([
        'users' => UserController::class,
        'tweets' => TweetController::class
    ]);

    Route::post('followTosomeone', [FollowController::class, 'followTosomeone'] );
    Route::get('followersCount', [FollowController::class, 'followersCount'] );
    Route::get('followingsCount', [FollowController::class, 'followingsCount'] );



    Route::post('logout', [AuthController::class, 'logout'] );
});
