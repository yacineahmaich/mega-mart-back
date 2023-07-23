<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;

class AdminOrderController extends Controller
{
    public function index()
    {
        return new OrderCollection(Order::paginate());
    }
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function toggleDeliveredStatus(Order $order)
    {
        $order->updateOrFail([
            'delivered' => !$order->delivered,
            'delivered_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
