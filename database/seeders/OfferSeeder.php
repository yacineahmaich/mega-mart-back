<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all()->random(6);
        $products->each(function (Product $product) {
            Offer::create([
                'end' => now()->addDays(rand(1, 20)),
                'product_id' => $product->id
            ]);
        });

        Offer::all()->each(function (Offer $offer) {
            $offer->image()->save(
                Image::factory(1)->create([
                    'imageable_type' => 'App\Offer',
                    'imageable_id' => $offer->id
                ])->first()
            );
        });
    }
}
