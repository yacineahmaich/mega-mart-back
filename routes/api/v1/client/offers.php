<?php

use App\Http\Controllers\Api\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/offers', [OfferController::class, 'index']);
