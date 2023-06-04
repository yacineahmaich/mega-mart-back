<?php

use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {
    // auth routes
    require __DIR__ . '/api/v1/auth.php';

    // client routes
    require __DIR__ . '/api/v1/client/home.php';
    require __DIR__ . '/api/v1/client/profile.php';
    require __DIR__ . '/api/v1/client/products.php';
    require __DIR__ . '/api/v1/client/categories.php';

    // admin routes
    Route::middleware(['auth:sanctum', 'admin'])
        ->prefix('admin')
        ->group(function () {
            require __DIR__ . '/api/v1/admin/products.php';
            require __DIR__ . '/api/v1/admin/categories.php';
            require __DIR__ . '/api/v1/admin/customers.php';
        });
});
