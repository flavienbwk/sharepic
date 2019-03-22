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

    // User subscriptions
    Route::post('account/subscriptions', 'AccountController@subscriptionsList');
    Route::post('account/subscribed', 'AccountController@subscribedList');
    Route::post('account/subscription', 'AccountController@subscription');
    Route::post('account/issubscribed', 'AccountController@issubscribed');

    // Publications (base)
    Route::post('publications/add', 'PublicationController@add');
    Route::post('publications/remove', 'PublicationController@remove');
    Route::post('publications', 'PublicationController@publications');
    Route::post('publication', 'PublicationController@publication');
    
    // Publications (comments)
    Route::post('publication/comments', 'PublicationController@comments');
    Route::post('publication/comment', 'PublicationController@comment');

    // Publications (reactions)
    Route::post('publication/reactions', 'PublicationController@reactions');
    Route::post('reaction', 'ReactionController@reaction');
    Route::post('reactions', 'ReactionController@reactions');
    
    // Conversations
    Route::post('conversations/add', 'ConversationController@add');
    
    // End
    // Now :
    // - Add reactions images and records in DB
    // - Populate the database with images, users and publications
    // - Tests
    // - Commit on GitLab
    // - Finish documentation of routes
    // - Prepare PostMan for API documentation
    // - Deploy the API on a server

});

Route::get('{any?}', function ($any = null) {
    $ApiResponse = new \App\ApiResponse();
    $ApiResponse->setMessage("Route not found.");
    return Response::json($ApiResponse->getResponse(), 404);
})->where('any', '.*');

Route::post('{any?}', function ($any = null) {
    $ApiResponse = new \App\ApiResponse();
    $ApiResponse->setMessage("Route not found.");
    return Response::json($ApiResponse->getResponse(), 404);
})->where('any', '.*');