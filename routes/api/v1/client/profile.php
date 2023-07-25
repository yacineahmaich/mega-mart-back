<?php

use App\Http\Controllers\Api\AccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
  ->group(function () {

    Route::post('/profile/edit', [AccountController::class, 'updateProfile']);

    Route::get('/profile', [AccountController::class, 'getProfile']);

    Route::post('/profile/avatar', [AccountController::class, 'setAvatar'])->middleware(['auth:sanctum']);
  });
