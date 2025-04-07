<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('questions')->insert([
            ['question_text' => 'Ilość osób'],
            ['question_text' => 'Maksymalna kwota na osobę'],
            ['question_text' => 'Rodzaj posiłku'],
            ['question_text' => 'Cel wizyty'],
            ['question_text' => 'Preferencje dietetyczne'],
        ]);
    }
}
