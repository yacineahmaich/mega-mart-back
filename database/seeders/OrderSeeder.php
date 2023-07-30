<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->take(60)->get();
        $products = Product::all();

        $customers->each(function ($customer) {
            $customer->orders()->delete();
        });

        foreach ($customers as $customer) {

            $orders = Order::factory(rand(0, 6))->create([
                'user_id' => $customer->id
            ]);

            foreach ($orders as $order) {
                $products_items = $products->random(rand(1, 10));
                $total_price = 0;
                foreach ($products_items as $product) {
                    $total_price += $product->price;

                    Item::create(
                        [
                            'price' => $product->price,
                            'quantity' => rand(1, 10),
                            'product_id' => $product->id,
                            'order_id' => $order->id,
                        ]
                    );
                };

                $order->total_price = $total_price;
                $order->save();
            }
        }
    }
}
