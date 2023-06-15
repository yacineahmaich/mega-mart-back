<?php

use App\Http\Controllers\Api\Admin\AdminDiscountController;
use Illuminate\Support\Facades\Route;

Route::get('/discounts', [AdminDiscountController::class, 'index']);


Route::post('/apply-discount', [AdminDiscountController::class, 'apply']);

Route::delete('/discounts/{discount}', [AdminDiscountController::class, 'delete']);
