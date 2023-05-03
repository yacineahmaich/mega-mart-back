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
        return [
            'name' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10, 120),
            'quantity' => $this->faker->numberBetween(0, 50),
        ];
    }
}
