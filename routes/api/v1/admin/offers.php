<?php

use App\Http\Controllers\Api\Admin\AdminOfferController;
use Illuminate\Support\Facades\Route;

Route::get('/offers', [AdminOfferController::class, 'index']);

Route::get('/offers/{offer}', [AdminOfferController::class, 'show']);

Route::put('/offers/{offer}', [AdminOfferController::class, 'update']);

Route::post('/offers', [AdminOfferController::class, 'store']);

Route::delete('/offers/{offer}', [AdminOfferController::class, 'destroy']);
