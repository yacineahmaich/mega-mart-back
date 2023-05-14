<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductWithCategoryAndImages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory(5)->create();

        $categories->each(function ($category) {

            $products = Product::factory(15)->create([
                'category_id' => $category->id
            ]);

            $products->each(function($product) {

                Review::factory(5)->create([
                    'product_id' => $product->id,
                    'customer_id' => Customer::all()->random()->id
                ]);

                Image::factory(6)->create([
                    'product_id' => $product->id
                ]);

            });

        });

    }
}
