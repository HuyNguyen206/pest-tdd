<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    public function run(): void
    {
        User::createOrFirst(['email' => 'nguyenlehuyuit@gmail.com'],[
            'name' => 'Huy Nguyen',
            'email_verified_at' => '2024-01-05 08:15:00',
            'password' => bcrypt('password'),
            'remember_token' => \Str::random(10),
            'current_team_id' => null,
            'profile_photo_path' => 'profiles/huy.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
