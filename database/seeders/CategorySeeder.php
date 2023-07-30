<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $main_categories = MainCategory::all();


        foreach ($main_categories as $main_category) {
            for ($i = 0; $i < 6; $i++) {
                $categories[] = Category::factory(1)->hasImage(Image::factory())->create([
                    'main_category_id' => $main_category->id
                ]);
            }
        }

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
    }
}
