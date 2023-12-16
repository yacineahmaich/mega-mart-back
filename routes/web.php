<?php

use App\Models\Order;
use App\Models\Product;
use Database\Seeders\OrderSeeder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset', function () {
    Product::restoreProductsQuantity();

    Order::truncate();

    $orderSeeder = new OrderSeeder();
    $orderSeeder->run();

    return 'SUCCESS';
});
