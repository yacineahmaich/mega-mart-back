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
        $users = User::all();
        $products = Product::factory(300)->create([
            'category_id' => 1
        ]);


        foreach ($products as $product) {
            $product['category_id'] = collect($categories)->random()->first()->id;
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
                $review['user_id'] = collect($users)->random()->first()->id;
                $review->save();
            }
            $product->save();
        }
    }
}
