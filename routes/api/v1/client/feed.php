<?php

use App\Http\Controllers\Api\FeedController;
use Illuminate\Support\Facades\Route;

Route::get('/feed', [FeedController::class, 'index']);
Route::get('/mc/{mainCategory:slug}/feed', [FeedController::class, 'mainCategoryFeed']);
