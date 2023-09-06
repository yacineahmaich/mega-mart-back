<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
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
            $numOfProducts = random_int(0, 15);
            Product::factory($numOfProducts)
                ->hasImages(Image::factory(6))
                ->hasReviews(
                    Review::factory(6)
                )
                ->create([
                    'category_id' => $category->id
                ]);
        }
    }
}
