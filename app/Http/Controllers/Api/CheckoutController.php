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
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{

    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $cart = $request->validated('cart');
            $delivery = $request->validated('delivery');


            // 1) get cart products
            $items_ids = array_map(fn ($item) => $item['id'], $cart);
            $products = Product::with('discount')->find($items_ids);

            // 2) create line items
            $line_items = [];
            $total_price = 0;
            foreach ($products as $product) {

                $tagetId = $product->id;
                // $itemInCart = collect($cart)->firstWhere('id', '=', $product->id);
                $filter_result = array_filter($cart, fn ($item) => $item['id'] === $tagetId);
                $itemInCart = reset($filter_result);

                if (!$itemInCart) {
                    throw new NotFoundHttpException();
                }

                $image = $product->images[0]->url;
                $price = $product->hasDiscount() ? $product->getDiscountPrice() : $product->price;

                $total_price += $price * $itemInCart['quantity'];

                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [$image]
                        ],
                        'unit_amount' => $price * 100,
                    ],
                    'quantity' => $itemInCart['quantity'],
                ];
            }

            // 3) create checkout session
            $session =  \Stripe\Checkout\Session::create([
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => env('FRONTEND_BASE_URL') . '/cart/checkout/{CHECKOUT_SESSION_ID}',
                'cancel_url' => env('FRONTEND_BASE_URL') . '/account/profile/my-orders?cancel=1',
            ]);


            DB::transaction(function ()
            use ($request, $total_price, $session, $cart, $products, $delivery) {
                // 4) create new order
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'total_price' => $total_price,
                    'checkout_session_id' => $session->id,
                    'shipping_address' => $delivery['shippingAddress'],
                    'email' => $delivery['email'],
                    'name' => $delivery['name'],
                    'phone' => $delivery['phone'],
                    'note' => $delivery['note'],
                    'checkout_url' => $session->url
                ]);



                // 5) create order items
                foreach ($products as $product) {
                    $itemInCart = collect($cart)->firstWhere('id', '=', $product->id);

                    Item::create([
                        'price' => $product->price,
                        'quantity' => $itemInCart['quantity'] ?? 1,
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                    ]);
                }
            });
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
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session');

        try {
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            $order = Order::where(
                'checkout_session_id',
                $session->id
            )
                ->first();

            if (!$order) {
                throw new NotFoundHttpException('order not found!');
            }


            return response()->json([
                'processed' => $order->status === 'paid',
                'order' => new OrderResource($order)
            ]);
        } catch (\Exception $e) {
            if ($e instanceof ApiErrorException) {
                return response()->json([
                    "message" => "Order not found"
                ]);
            }
            return response()->json([
                "message" => "Something went wrong while processing your paiment, Please try again"
            ]);
        }
    }

    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $order = Order::where('checkout_session_id', $session->id)->first();

                if ($order && $order->status === "unpaid") {
                    $order->status = 'paid';
                    $order->paid_at = Carbon::now();
                    $order->save();
                    // TODO - send notification email to customer
                }


            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response()->noContent();
    }
}
