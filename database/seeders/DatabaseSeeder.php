<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function($user) {
            Customer::create([
                'user_id' => $user->id,
            ]);
        });

        $this->call(ProductWithCategoryAndImages::class);
    }
}
