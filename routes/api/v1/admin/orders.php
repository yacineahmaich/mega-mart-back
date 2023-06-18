<?php

use App\Http\Controllers\Api\Admin\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', [AdminOrderController::class, 'index']);
