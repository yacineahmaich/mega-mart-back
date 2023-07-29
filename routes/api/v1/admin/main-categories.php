<?php

use App\Http\Controllers\Api\Admin\AdminMainCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/main-categories', [AdminMainCategoryController::class, 'index']);

Route::get('/main-categories/all', [AdminMainCategoryController::class, 'all']);

Route::get('/main-categories/{mainCategory}', [AdminMainCategoryController::class, 'show'])->whereNumber('mainCategory');

Route::post('/main-categories', [AdminMainCategoryController::class, 'store']);

Route::put('/main-categories/{mainCategory}', [AdminMainCategoryController::class, 'update']);

Route::delete('/main-categories/{mainCategory}', [AdminMainCategoryController::class, 'destroy']);
