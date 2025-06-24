<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    /**
     * Creates or updates a test user with a fixed email and password.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'testuser@example.com'], 
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
    }
}
