<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    // Brand routes
    Route::middleware(['auth:sanctum', 'permission:view brand|perform all task'])->group(function () {
        Route::get('brands', [BrandController::class, 'index']);
        Route::get('brands/{id}', [BrandController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'permission:create brand|perform all task'])->group(function () {
        Route::post('brands', [BrandController::class, 'store']);
    });

    Route::middleware(['permission:edit brand|perform all task'])->group(function () {
        Route::put('brands/{id}', [BrandController::class, 'update']);
        Route::patch('brands/{id}', [BrandController::class, 'update']);
    });

    Route::middleware(['permission:delete brand|perform all task'])->group(function () {
        Route::delete('brands/{id}', [BrandController::class, 'destroy']);
    });

    // Product routes
    Route::middleware(['permission:view car|perform all task'])->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
    });

    Route::middleware(['permission:create car|perform all task'])->group(function () {
        Route::post('products', [ProductController::class, 'store']);
    });

    Route::middleware(['permission:edit car|perform all task'])->group(function () {
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::patch('products/{id}', [ProductController::class, 'update']);
    });

    Route::middleware(['permission:delete car|perform all task'])->group(function () {
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
    });

    // in case admin want to moderate photo
    Route::middleware(['role_or_permission:perform all task'])->group(function () {
        Route::apiResource('product-media', ProductMediaController::class);
    });
});
