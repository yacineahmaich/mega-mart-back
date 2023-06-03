<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Image;
use App\Models\MainCategory;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'yacine',
            'email' => 'yacine@gmail.com',
            'password' => Hash::make('husahusa@')
        ]);

        $users = User::factory(20)->create();

        $main_categories = MainCategory::factory(6)->create();

        foreach ($main_categories as $main_category) {
            $categories[] = Category::factory(1)->create([
                'main_category_id' => $main_category->id
            ]);
            $categories[] = Category::factory(1)->create([
                'main_category_id' => $main_category->id
            ]);
            $categories[] = Category::factory(1)->create([
                'main_category_id' => $main_category->id
            ]);
        }

        $products = Product::factory(75)->create([
            'category_id' => 1
        ]);

        foreach ($products as $product) {
            $product->category_id = collect($categories)->random()->first()->id;

            $product->images()->saveMany(
                Image::factory(6)->create([
                    'imageable_type' => 'App\Product',
                    'imageable_id' => $product->id
                ])
            );

            $reviews = $product->reviews()->saveMany(
                Review::factory(15)->create([
                    'user_id' => 1,
                    'product_id' => $product->id
                ])
            );

            foreach ($reviews as $review) {
                $review->user_id = collect($users)->random()->first()->id;
                $review->save();
            }


            $product->save();
        }

        collect($products)->random(6)->each(function (Product $product) {
            Offer::create([
                'offer_start' => now()->addMinutes(rand(1, 10)),
                'offer_end' => now()->addDays(rand(1, 5)),
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
