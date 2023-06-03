<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence(5);
        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10, 120),
            'quantity' => $this->faker->numberBetween(0, 50),
        ];
    }
}
