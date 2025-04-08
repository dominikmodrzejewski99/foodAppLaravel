<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\QuestionsTableSeeder;
use Database\Seeders\AnswersTableSeeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\AnswerRestaurantSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Najpierw usuwamy istniejących użytkowników
        DB::table('users')->where('email', 'test@example.com')->delete();

        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            QuestionsTableSeeder::class,
            AnswersTableSeeder::class,
            RestaurantSeeder::class,
            AnswerRestaurantSeeder::class,
        ]);
    }
}
