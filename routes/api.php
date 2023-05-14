<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\CartController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
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

// Guests Routes
Route::apiResource('products', ProductController::class);
Route::get('/products/{product:slug}/slug', [ProductController::class, 'getProductBySlug']);

Route::apiResource('categories', CategoryController::class);

// Client Routes
Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // profile
        Route::post('/profile/edit', [AccountController::class, 'updateProfile']);
    }
);

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function() {
    Route::get('test', function() {
        return response([
            'message' => 'welcome to admin group'
        ]);
    });
});