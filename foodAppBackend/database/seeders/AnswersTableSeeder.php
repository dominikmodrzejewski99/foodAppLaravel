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
            if ($question->question_text == 'Ilość osób') {
                $answers[] = ['answer_text' => 'jedna', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'dwie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'trzy', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'cztery i więcej', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Maksymalna kwota na osobę') {
                $answers[] = ['answer_text' => 'Do 30 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => '30 - 50 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => '50 - 80 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'kwota nie ma znaczenia', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Rodzaj posiłku') {
                $answers[] = ['answer_text' => 'sniadanie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'lunch', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'obiad', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'kolacja', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'deser', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Cel wizyty') {
                $answers[] = ['answer_text' => 'Spotkanie biznesowe', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Świętowanie (urodziny, rocznica itp.)', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Wydarzenie towarzyskie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Rodzinna uroczystość', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Rekreacja', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Preferencje dietetyczne') {
                $answers[] = ['answer_text' => 'Wegetariańska', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Wegańska', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Bezglutenowa', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Bez laktozy', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Brak preferencji', 'question_id' => $question->id];
            }
        }

        DB::table('answers')->insert($answers);
    }
}
