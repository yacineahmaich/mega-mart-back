<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(60)
            ->hasAvatar(Image::factory())
            ->create();

        // ADMIN
        User::create([
            'name' => 'demo',
            'email' => 'demo@gmail.com',
            'password' => Hash::make('demodemo@'),
            'role' => 'admin'
        ]);
    }
}
