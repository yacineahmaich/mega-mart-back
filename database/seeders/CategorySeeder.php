<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\MainCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $main_categories = MainCategory::all();

        foreach ($main_categories as $main_category) {
            Category::factory(6)
                ->hasImage(Image::factory())
                ->create([
                    'main_category_id' => $main_category->id
                ]);
        }
    }
}
