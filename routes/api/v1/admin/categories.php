<?php

use App\Http\Controllers\Api\Admin\AdminCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware([])
  ->group(function () {
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->whereNumber('category');
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);
  });
