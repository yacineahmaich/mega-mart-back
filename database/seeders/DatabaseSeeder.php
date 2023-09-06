<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MainCategorySeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OfferSeeder::class,
            OrderSeeder::class
        ]);
    }
}
