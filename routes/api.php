<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMediaController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    // Brand routes
    Route::middleware(['auth:sanctum', 'permission:view brand|perform all task'])->group(function () {
        Route::get('brands', [BrandController::class, 'index']);
        Route::get('brands/{id}', [BrandController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'permission:create brand|perform all task'])->group(function () {
        Route::post('brands', [BrandController::class, 'store']);
    });

    Route::middleware(['auth:sanctum', 'permission:edit brand|perform all task'])->group(function () {
        Route::put('brands/{id}', [BrandController::class, 'update']);
        Route::patch('brands/{id}', [BrandController::class, 'update']);
    });

    Route::middleware(['auth:sanctum', 'permission:delete brand|perform all task'])->group(function () {
        Route::delete('brands/{id}', [BrandController::class, 'destroy']);
    });

    // Product routes
    Route::middleware(['auth:sanctum', 'permission:view car|perform all task'])->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'permission:create car|perform all task'])->group(function () {
        Route::post('products', [ProductController::class, 'store']);
    });

    Route::middleware(['auth:sanctum', 'permission:edit car|perform all task'])->group(function () {
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::patch('products/{id}', [ProductController::class, 'update']);
        Route::post('products/{id}/add-media', [ProductController::class, 'addMedia']);
        Route::delete('products/{id}/remove-media/{media_id}', [ProductController::class, 'removeMedia']);
    });

    Route::middleware(['auth:sanctum', 'permission:delete car|perform all task'])->group(function () {
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
    });
});
