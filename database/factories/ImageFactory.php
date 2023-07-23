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
        return [
            'name' => $this->faker->name(),
            // 'url' =>  $this->faker->imageUrl(800, 800, null, true, null)
            'url' =>  "https://www.marjanemall.ma/media/catalog/product/cache/2d24969db123d312c3d8c8732be47ef4/2/_/2_3_9_3_1_700x700_son0711719410393_rw_jeu-video-playstation-5-sony-god-of-war-ragnarok.jpg"
        ];
    }
}
