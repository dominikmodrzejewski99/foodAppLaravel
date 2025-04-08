<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class CleanupDuplicatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Najpierw usuwamy wszystkie powiązania answer_restaurant
        DB::table('answer_restaurant')->delete();
        
        // Pobierz wszystkie pytania
        $questions = Question::all();
        
        // Tablica do przechowywania unikalnych pytań
        $uniqueQuestions = [];
        $duplicateQuestionIds = [];
        
        // Znajdź duplikaty pytań
        foreach ($questions as $question) {
            $questionText = $question->question_text;
            
            if (!isset($uniqueQuestions[$questionText])) {
                $uniqueQuestions[$questionText] = $question->id;
            } else {
                // To jest duplikat
                $duplicateQuestionIds[] = $question->id;
            }
        }
        
        // Usuń odpowiedzi powiązane z duplikatami pytań
        if (!empty($duplicateQuestionIds)) {
            Answer::whereIn('question_id', $duplicateQuestionIds)->delete();
            
            // Usuń duplikaty pytań
            Question::whereIn('id', $duplicateQuestionIds)->delete();
            
            $this->command->info('Usunięto ' . count($duplicateQuestionIds) . ' duplikatów pytań i ich odpowiedzi.');
        } else {
            $this->command->info('Nie znaleziono duplikatów pytań.');
        }
        
        // Teraz zajmijmy się duplikatami odpowiedzi
        $questions = Question::all();
        
        foreach ($questions as $question) {
            $answers = Answer::where('question_id', $question->id)->get();
            
            $uniqueAnswers = [];
            $duplicateAnswerIds = [];
            
            foreach ($answers as $answer) {
                $answerText = $answer->answer_text;
                
                if (!isset($uniqueAnswers[$answerText])) {
                    $uniqueAnswers[$answerText] = $answer->id;
                } else {
                    // To jest duplikat
                    $duplicateAnswerIds[] = $answer->id;
                }
            }
            
            // Usuń duplikaty odpowiedzi
            if (!empty($duplicateAnswerIds)) {
                Answer::whereIn('id', $duplicateAnswerIds)->delete();
                $this->command->info('Usunięto ' . count($duplicateAnswerIds) . ' duplikatów odpowiedzi dla pytania: ' . $question->question_text);
            }
        }
        
        $this->command->info('Czyszczenie duplikatów zakończone.');
    }
}
