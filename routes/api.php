<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminCustomerController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// =====================================================
// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product:slug}', [ProductController::class, 'show']);
Route::get('/products/{id}/reviews', [ProductController::class, 'getReviews']);


Route::get('/categories', [CategoryController::class, 'index']);


// =====================================================
// Client Routes
Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // profile
        Route::post('/profile/edit', [AccountController::class, 'updateProfile']);
    }
);


// =====================================================
// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('products',AdminProductController::class);
    Route::apiResource('categories',AdminCategoryController::class);
    Route::apiResource('customers',AdminCustomerController::class)
            ->except(['create', 'update']);
    Route::get(
        '/products/{id}/reviews',
         [AdminProductController::class, 'getReviews']
    );
});