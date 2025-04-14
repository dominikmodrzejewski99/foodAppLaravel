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
        // Usuwamy wszystkie pytania przed dodaniem nowych
        DB::table('questions')->delete();

        DB::table('questions')->insert([
            ['question_text' => 'Z kim wybierasz się do restauracji?'],
            ['question_text' => 'Jaki masz budżet na osobę?'],
            ['question_text' => 'O jakiej porze planujesz wizytę?'],
            ['question_text' => 'Jaki jest cel Twojej wizyty?'],
            ['question_text' => 'Jakiego klimatu szukasz?'],
            ['question_text' => 'Jakie doświadczenie kulinarne Cię interesuje?'],
            ['question_text' => 'Jakie dodatki są dla Ciebie ważne?'],
            ['question_text' => 'Na ile ważna jest cisza i prywatność?'],
        ]);
    }
}
