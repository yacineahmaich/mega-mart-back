<?php

use App\Http\Controllers\Api\Admin\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', [AdminOrderController::class, 'index']);

Route::get('/orders/{order}', [AdminOrderController::class, 'show']);

Route::post('/orders/{order}/delivered', [AdminOrderController::class, 'toggleDeliveredStatus']);
