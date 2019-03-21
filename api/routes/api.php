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

    // Authentication routes
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/expiration', 'AuthController@expiration');
});

Route::group(['middleware' => ['web', 'authenticated']], function() {

    // Authentication routes
    Route::post('auth/info', 'AuthController@info');
    Route::post('auth/expiration', 'AuthController@expiration');
    
    // Avatar-related routes
    Route::post('account/avatar/add', 'AccountController@addAvatar');
    Route::post('account/avatar', 'AccountController@avatar');
    
    // Notifications route
    Route::post('account/notifications', 'AccountController@notifications');
    Route::post('account/notification/seen', 'AccountController@notificationSeen');
    
    // User subscription
    
    // Publications (comments)
    
    // Publications (base)
    
    // Publications (reactions)
    
    // Publications (comments)
    
});
