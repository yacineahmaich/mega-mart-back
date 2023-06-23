<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function myOrders(User $user)
    {
        return new OrderCollection($user->orders()->latest()->get());
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
