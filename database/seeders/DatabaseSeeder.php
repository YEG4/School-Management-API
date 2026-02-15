<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $students = User::factory(10)->create();
        $courses = Course::factory(10)->create();

        $admin = User::factory()->admin()->create([
            'email' => 'ib_admin@gmail.com',
            'name' => 'ib_admin',
            'password' => Hash::make('password1@#'),
        ]);

        $token = $admin->createToken('api_token')->plainTextToken;

        $this->command->info("Admin Token: $token");
    }
}
