<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'byIds']);

Route::get('/products/{product:slug}', [ProductController::class, 'show']);

Route::get('/products/{id}/reviews', [ProductController::class, 'getReviews']);

Route::post('/products/{id}/reviews', [ProductController::class, 'storeReview'])
  ->middleware('auth:sanctum');

Route::get(
  '/categories/{category:slug}/products',
  [ProductController::class, 'categoryProducts']
);
Route::get(
  '/categories/{category:slug}/hot-products',
  [ProductController::class, 'categoryHotProducts']
);

Route::get(
  '/search',
  [ProductController::class, 'search']
);
