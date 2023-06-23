<?php

use App\Http\Controllers\Api\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

  Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);

  Route::get('/checkout/success', [CheckoutController::class, 'success']);

  Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->withoutMiddleware('auth:sanctum');
});
