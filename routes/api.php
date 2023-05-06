<?php

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

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// Products
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::group(['middleware' => ['web']], function () {
    // your routes here
    // Route::get('cart', [CartController::class,"index"]);
    Route::post('cart', [CartController::class,"addToCart"]);
    // Route::delete('cart', [CartController::class,"destroy"]);
});