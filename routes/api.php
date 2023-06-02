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

Route::prefix("v1")->group(function () {
    // auth routes
    require __DIR__ . '/api/v1/auth.php';

    // client routes
    require __DIR__ . '/api/v1/client/profile.php';
    require __DIR__ . '/api/v1/client/products.php';
    require __DIR__ . '/api/v1/client/categories.php';

    Route::middleware(['auth:sanctum', 'admin'])
        ->prefix('admin')
        ->group(function () {
            // admin routes
            require __DIR__ . '/api/v1/admin/products.php';
            require __DIR__ . '/api/v1/admin/categories.php';
            require __DIR__ . '/api/v1/admin/customers.php';
        });
});

// Auth
// Route::post('/signup', [AuthController::class, 'signup']);
// Route::post('/login', [AuthController::class, 'login']);

// // =====================================================
// // Public Routes
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{product:slug}', [ProductController::class, 'show']);
// Route::get('/products/{id}/reviews', [ProductController::class, 'getReviews']);


// Route::get('/categories', [CategoryController::class, 'index']);


// // =====================================================
// // Client Routes
// Route::middleware('auth:sanctum')->group(
//     function () {
//         Route::get('/me', [AuthController::class, 'me']);
//         Route::post('/logout', [AuthController::class, 'logout']);

//         // profile
//         Route::post('/profile/edit', [AccountController::class, 'updateProfile']);
//     }
// );


// // =====================================================
// // Admin Routes
// Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum, admin'], function () {
//     Route::apiResource('products', AdminProductController::class);
//     Route::apiResource('categories', AdminCategoryController::class);
//     Route::apiResource('customers', AdminCustomerController::class)
//         ->except(['create', 'update']);
// });
