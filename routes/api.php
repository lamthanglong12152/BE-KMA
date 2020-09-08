<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::post('get-access-token', 'AccessTokenController@getAccessToken');
});

Route::group(['namespace' => 'User', 'middleware'  => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('add', 'UserController@add');
        Route::post('login', 'UserController@login');
        Route::get('home', 'UserController@home')->middleware(['admin', 'student']);
        Route::get('admin-home', function () {
            return "admin-home";
        })->middleware('admin');
    });
});
