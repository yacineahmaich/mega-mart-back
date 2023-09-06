<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\MainCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainCategory::factory(6)
            ->hasImage(Image::factory())
            ->create();
    }
}
