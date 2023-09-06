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
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        // return [
        //     "name" => $this->faker->name(),
        //     'url' => $faker->imageUrl($width = 600, $height = 800),
        // ];

        return [
            'name' => $this->faker->name(),
            'url' =>  $this->faker->imageUrl(800, 800, null, true, null, true)
        ];
    }
}
