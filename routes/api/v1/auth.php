<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
  ->group(function () {

    Route::post('/signup', [AuthController::class, 'signup'])
      ->withoutMiddleware('auth');

    Route::post('/login', [AuthController::class, 'login'])
      ->withoutMiddleware('auth');

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
  });
