<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $questions = DB::table('questions')->get();

        $answers = [];

        foreach ($questions as $question) {
            if ($question->question_text == 'Jaki budżet planujecie przeznaczyć na tę wizytę?') {
                $answers[] = ['answer_text' => 'Do 100 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Od 100 zł do 200 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Od 200 zł do 500 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Powyżej 500 zł', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Ilu gości planujecie przyprowadzić do naszej restauracji?') {
                $answers[] = ['answer_text' => 'Będziemy w dwie osoby', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Będziemy w trzy osoby', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Będziemy w cztery osoby', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Będziemy w pięć osób', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jaki będzie charakter tej wizyty?') {
                $answers[] = ['answer_text' => 'Romantyczny', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Biznesowy', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Przyjacielski', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Rodzinny', 'question_id' => $question->id];
            }
        }

        DB::table('answers')->insert($answers);
    }
}
