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
            ['question_text' => 'Jaki budżet planujecie przeznaczyć na tę wizytę?'],
            ['question_text' => 'Ilu gości planujecie przyprowadzić do naszej restauracji?'],
            ['question_text' => 'Jaki będzie charakter tej wizyty?'],
        ]);
    }
}
