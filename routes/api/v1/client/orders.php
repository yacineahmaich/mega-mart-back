<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/users/{user}/orders', [OrderController::class, 'myOrders']);
  Route::get('/orders/{order}', [OrderController::class, 'show']);
});
