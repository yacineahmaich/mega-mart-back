<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\User;

class OrderController extends Controller
{
    public function myOrders(User $user)
    {
        return new OrderCollection($user->orders);
    }
}
