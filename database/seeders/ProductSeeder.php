<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            $products = Product::factory(15)
                ->hasReviews(
                    Review::factory(6)
                )
                ->create([
                    'category_id' => $category->id
                ]);

            foreach ($products as $product) {
                $product->images()->saveMany(
                    Image::factory(6)->create([
                        'imageable_type' => 'App\Product',
                        'imageable_id' => $product->id
                    ])
                );
                $product->reviews()->saveMany(
                    Review::factory(6)->create([
                        'user_id' => User::inRandomOrder()->first()->id,
                        'product_id' => $product->id
                    ])
                );
            }
        }
    }
}
