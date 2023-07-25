<?php

namespace Database\Seeders;

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
    public function run(): void
    {

        // GENERATE USERS
        User::create([
            'name' => 'yacine',
            'email' => 'yacine@gmail.com',
            'password' => Hash::make('husahusa@'),
            'role' => 'admin'
        ]);
        $users = User::factory(30)->create();
        collect($users)->each(function (User $user) {
            $user->avatar()->save(
                Image::factory(1)->create([
                    'imageable_type' => 'App\User',
                    'imageable_id' => $user->id
                ])->first()
            );
        });

        // GENERATE MAIN CATEGORIES
        $main_categories = MainCategory::factory(6)->hasImage(Image::factory())->create();
        foreach ($main_categories as $main_category) {
            for ($i = 0; $i < 6; $i++) {
                $categories[] = Category::factory(1)->hasImage(Image::factory())->create([
                    'main_category_id' => $main_category->id
                ]);
            }
        }

        // GENERATE PRODUCTS
        $products = Product::factory(300)->create([
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

        $this->call([
            OrderSeeder::class
        ]);
    }
}
