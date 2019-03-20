<?php

use Illuminate\Http\Request;

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

Route::get('/', function () {
    $ApiResponse = new \App\ApiResponse();
    $ApiResponse->setMessage("Reachable API.");
    return Response::json($ApiResponse->getResponse(), 200);
});

Route::group(['middleware' => ['web']], function() {

    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/expiration', 'AuthController@expiration');
});

Route::group(['middleware' => ['web', 'authenticated']], function() {
    Route::post('auth/info', 'AuthController@info');
});
