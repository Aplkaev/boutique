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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    /* authors routes */
    Route::prefix('/authors')->group(function () {
        Route::get('/', 'Api\AuthorController@index');
        Route::get('/{id}', 'Api\AuthorController@show');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'Api\AuthorController@store');
            Route::put('/{id}', 'Api\AuthorController@update');
            Route::delete('/{id}', 'Api\AuthorController@destroy');
        });
    });
    /* books routes */
    Route::prefix('/books')->group(function () {
        Route::get('/', 'Api\BookController@index');
        Route::get('/{id}', 'Api\BookController@show');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'Api\BookController@store');
            Route::put('/{id}', 'Api\BookController@update');
            Route::delete('/{id}', 'Api\BookController@destroy');
        });
    });

});
