<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/offers', [HomeController::class, 'offers']);

Route::get('/m-categories', [HomeController::class, 'mCategories']);

Route::get('/{mainCategory}/products', [HomeController::class, 'mCategoryProducts']);
