<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $service
    ) {
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            $session = $this->service->createSession($request);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong while proccessing your Paiment!',
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'session_url' => $session->url
        ]);
    }


    public function status(Request $request)
    {
        $this->service->getCheckoutStatus($request);
    }

    public function webhook()
    {
        $this->service->webhook();
    }
}
