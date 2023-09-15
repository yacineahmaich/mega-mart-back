<?php

use App\Http\Controllers\Api\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/store-stats', [AdminDashboardController::class, 'stats']);

Route::get('/week-sales', [AdminDashboardController::class, 'sales']);

Route::get('/sales-contribution', [AdminDashboardController::class, 'salesDistro']);

Route::get('/latest-orders', [AdminDashboardController::class, 'latestOrders']);

Route::get('/shared-stats', [AdminDashboardController::class, 'sharedStats']);
