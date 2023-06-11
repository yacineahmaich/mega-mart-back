<?php

use App\Http\Controllers\Api\MainCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/m-categories', [MainCategoryController::class, 'index']);

Route::get(
  '/mc/{mainCategory:slug}',
  [MainCategoryController::class, 'show']
);
