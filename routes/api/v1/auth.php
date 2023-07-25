<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
  ->group(function () {

    Route::post('/signup', [AuthController::class, 'signup'])
      ->withoutMiddleware('auth:sanctum');

    Route::post('/login', [AuthController::class, 'login'])
      ->withoutMiddleware('auth:sanctum');

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
  });
