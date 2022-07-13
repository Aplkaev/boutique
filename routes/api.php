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
    Route::prefix('/auth')->as('auth.')->group(function () {
        Route::post('/login', [Api\AuthController::class, 'login'])->name('login');
        Route::post('/register', [Api\AuthController::class, 'register'])->name('register');
        Route::middleware('auth:sanctum')->post('/logout', [Api\AuthController::class, 'logout'])->name('logout');
    });

    /* authors routes */
    Route::prefix('/authors')->as('authors.')->group(function () {
        Route::get('/', [Api\AuthorController::class, 'index'])->name('index');
        Route::get('/{slug}', [Api\AuthorController::class, 'show'])->name('show');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [Api\AuthorController::class, 'store'])->name('store');
            Route::put('/{slug}', [Api\AuthorController::class, 'update'])->name('update');
            Route::delete('/{slug}', [Api\AuthorController::class, 'destroy'])->name('destroy');
        });
    });

    /* books routes */
    Route::prefix('/books')->as('books.')->group(function () {
        Route::get('/', [Api\BookController::class, 'index'])->name('index');
        Route::get('/{slug}', [Api\BookController::class, 'show'])->name('show');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [Api\BookController::class, 'store'])->name('store');
            Route::put('/{slug}', [Api\BookController::class, 'update'])->name('update');
            Route::delete('/{slug}', [Api\BookController::class, 'destroy'])->name('destroy');
        });
    });

});
