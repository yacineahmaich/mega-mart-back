<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $cart = $request->validated('cart');
            $delivery = $request->validated('delivery');


            // 1) get cart products
            $items_ids = array_keys($cart);
            $products = Product::with('discount')->find($items_ids);

            // 2) create line items
            $line_items = [];
            $total_price = 0;
            foreach ($products as $product) {
                $image = $product->images[0]->url;

                $total_price += $product->price;

                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [$image]
                        ],
                        'unit_amount' => $product->price * 100,
                    ],
                    'quantity' => $cart[$product->id]['quantity'],
                ];
            }

            // 3) create checkout session
            $session =  \Stripe\Checkout\Session::create([
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => env('FRONTEND_BASE_URL') . '/cart/checkout/{CHECKOUT_SESSION_ID}',
                'cancel_url' => env('FRONTEND_BASE_URL') . '/checkout',
            ]);


            DB::transaction(function ()
            use ($request, $total_price, $session, $cart, $products, $delivery) {
                // 4) create new order
                $order = new Order();

                $order->user_id = $request->user()->id;
                $order->total_price = $total_price;
                $order->checkout_session_id = $session->id;

                $order->shipping_address = $delivery['shippingAddress'];
                $order->email = $delivery['email'];
                $order->name = $delivery['name'];
                $order->phone = $delivery['phone'];
                $order->note = $delivery['note'];
                $order->save();


                // 5) create order items
                foreach ($products as $product) {
                    $item = new Item();
                    $item->price = $product->price;
                    $item->quantity = $cart[$product->id]?->quantity ?? 1;
                    $item->product_id = $product->id;
                    $item->order_id = $order->id;

                    $item->save();
                }
            });

            return response()->json([
                'session_url' => $session->url
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'checkout proccess failed! Please try again'
            ], 500);
        }
    }


    public function verifyStatus(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session_id = $request->session;

        try {
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            $order = Order::where('checkout_session_id', $session->id)->first();

            if (!$order) {
                return response('', 404);
            }

            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->paid_at = Carbon::now();
                $order->save();
            }
            return new OrderResource($order);
        } catch (\Throwable $th) {
            return response('', 404);
        }
    }
}
