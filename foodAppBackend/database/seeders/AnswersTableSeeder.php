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
        // Usuwamy wszystkie odpowiedzi przed dodaniem nowych
        DB::table('answers')->delete();

        $questions = DB::table('questions')->get();

        $answers = [];

        foreach ($questions as $question) {
            if ($question->question_text == 'Z kim wybierasz się do restauracji?') {
                $answers[] = ['answer_text' => 'Sam/a', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Z drugą połówką', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Ze znajomymi', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Z rodziną', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jaki masz budżet na osobę?') {
                $answers[] = ['answer_text' => 'Do 30 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => '30–60 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => '60–100 zł', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Nie liczę się z kosztami', 'question_id' => $question->id];
            }

            if ($question->question_text == 'O jakiej porze planujesz wizytę?') {
                $answers[] = ['answer_text' => 'Śniadanie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Lunch', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Obiad', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Kolacja', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jaki jest cel Twojej wizyty?') {
                $answers[] = ['answer_text' => 'Spotkanie towarzyskie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Świętowanie (urodziny, rocznica itp.)', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Spotkanie biznesowe', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Randka', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jakiego klimatu szukasz?') {
                $answers[] = ['answer_text' => 'Kameralnie i romantycznie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Swobodnie i na luzie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Nowocześnie i designersko', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Elegancko i z klasą', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jakie doświadczenie kulinarne Cię interesuje?') {
                $answers[] = ['answer_text' => 'Coś zaskakującego', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Smaki kuchni zagranicznej', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Tradycyjnie i lokalne smaki', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Fine dining – degustacja i forma', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Jakie dodatki są dla Ciebie ważne?') {
                $answers[] = ['answer_text' => 'Oferta barowa', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Ogórdek / taras', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Ciekawa lokalizacja (np. z ładnym widokiem)', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Wygodne miejsce, np. do pracy', 'question_id' => $question->id];
            }

            if ($question->question_text == 'Na ile ważna jest cisza i prywatność?') {
                $answers[] = ['answer_text' => 'Bardzo ważna – chcę spokoju', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Umiarkowanie', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Lubię miejsca tętniące życiem', 'question_id' => $question->id];
                $answers[] = ['answer_text' => 'Jest mi to obojętne', 'question_id' => $question->id];
            }
        }

        DB::table('answers')->insert($answers);
    }
}
