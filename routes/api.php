<?php

use App\Http\Controllers\Api\FeedController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {
    // auth routes
    require __DIR__ . '/api/v1/auth.php';

    // client routes

    require __DIR__ . '/api/v1/client/feed.php';
    require __DIR__ . '/api/v1/client/main-categories.php';
    require __DIR__ . '/api/v1/client/profile.php';
    require __DIR__ . '/api/v1/client/products.php';
    require __DIR__ . '/api/v1/client/categories.php';
    require __DIR__ . '/api/v1/client/checkout.php';
    require __DIR__ . '/api/v1/client/orders.php';

    // admin routes
    Route::middleware([
        'auth:sanctum', 'admin', 'preventMutationsOnProd'
    ])
        ->prefix('admin')
        ->group(function () {
            require __DIR__ . '/api/v1/admin/products.php';
            require __DIR__ . '/api/v1/admin/main-categories.php';
            require __DIR__ . '/api/v1/admin/categories.php';
            require __DIR__ . '/api/v1/admin/customers.php';
            require __DIR__ . '/api/v1/admin/discounts.php';
            require __DIR__ . '/api/v1/admin/orders.php';
            require __DIR__ . '/api/v1/admin/dashboard.php';
        });
});
