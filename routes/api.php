<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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
    /* auth routes */
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [Api\AuthController::class, 'login']);
        Route::post('/register', [Api\AuthController::class, 'register']);
        Route::middleware('auth:sanctum')->post('/logout', [Api\AuthController::class, 'logout']);
    });

    /* authors routes */
    Route::prefix('/authors')->group(function () {
        Route::get('/', [Api\AuthorController::class, 'index']);
        Route::get('/{slug}', [Api\AuthorController::class, 'show']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [Api\AuthorController::class, 'store']);
            Route::put('/{slug}', [Api\AuthorController::class, 'update']);
            Route::delete('/{slug}', [Api\AuthorController::class, 'destroy']);
        });
    });

    /* books routes */
    Route::prefix('/books')->group(function () {
        Route::get('/', [Api\BookController::class, 'index']);
        Route::get('/{slug}', [Api\BookController::class, 'show']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [Api\BookController::class, 'store']);
            Route::put('/{slug}', [Api\BookController::class, 'update']);
            Route::delete('/{slug}', [Api\BookController::class, 'destroy']);
        });
    });

});
