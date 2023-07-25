<?php

use App\Http\Controllers\Api\Admin\AdminDiscountController;
use Illuminate\Support\Facades\Route;

Route::get('/discounts', [AdminDiscountController::class, 'index']);

Route::get('/discounts/{discount}', [AdminDiscountController::class, 'show']);

Route::post('/apply-discount', [AdminDiscountController::class, 'apply']);

Route::put('/discounts/{discount}', [AdminDiscountController::class, 'update']);

Route::delete('/discounts/{discount}', [AdminDiscountController::class, 'delete']);
