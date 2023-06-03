<?php

use App\Http\Controllers\Api\Admin\AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [AdminProductController::class, 'index']);

Route::get('/products/{product}', [AdminProductController::class, 'show'])->whereNumber('product');

Route::post('/products', [AdminProductController::class, 'store']);

Route::put('/products/{product}', [AdminProductController::class, 'update']);

Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);
