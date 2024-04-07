<?php

use App\Domain\Book\Http\Controllers\BookController;
use App\Domain\Store\Http\Controllers\StoreController;
use App\Domain\User\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([ 'middleware' => 'guest' ], function ($router) {
    Route::group([ 'prefix' => 'auth' ], function ($router) {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
        });
    });
});

Route::group([ 'middleware' => 'auth:api' ], function ($router) {
    Route::group([ 'prefix' => 'auth' ], function ($router) {
        Route::controller(AuthController::class)->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });
});

Route::group([ 'middleware' => 'auth:api' ], function ($router) {
    Route::apiResource('books', BookController::class);
    Route::apiResource('stores', StoreController::class);
});


