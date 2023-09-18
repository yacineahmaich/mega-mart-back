<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['paid', 'Unpaid']);
        $paid_at = $status === 'paid'
            ? fake()
            ->dateTimeBetween(
                Carbon::now()->subWeek()->subWeek(),
                Carbon::now()->addWeek(),
            )
            : null;

        return [
            'status' => $status,
            'total_price' => 1,
            'name' => $this->faker->word(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'shipping_address' => $this->faker->address(),
            'note' => $this->faker->sentence(),
            'delivered' => true,
            'delivered_at' => $this->faker->date(),
            'paid_at' => $paid_at?->format('Y-m-d')
        ];
    }
}
