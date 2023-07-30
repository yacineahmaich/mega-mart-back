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
        $users = User::factory(60)->create();
        collect($users)->each(function (User $user) {
            $user->avatar()->save(
                Image::factory(1)->create([
                    'imageable_type' => 'App\User',
                    'imageable_id' => $user->id
                ])->first()
            );
        });

        // GENERATE USERS
        User::create([
            'name' => 'demo',
            'email' => 'demo@gmail.com',
            'password' => Hash::make('demodemo@'),
            'role' => 'admin'
        ]);
    }
}
