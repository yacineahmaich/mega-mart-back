<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $imagespath = public_path('storage/images');
        // if(!File::exists($imagespath)){
        //     File::makeDirectory($imagespath);
        // }
        return [
            'url' =>  $this->faker->imageUrl(800,800, null, true,null,true) 
        ];
    }
}
