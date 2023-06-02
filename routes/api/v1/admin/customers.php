<?php

use App\Http\Controllers\Api\Admin\AdminCustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware([])
  ->group(function () {
    Route::get('/customers', [AdminCustomerController::class, 'index']);
    Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])->whereNumber('customer');
    Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy']);
  });
