<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Restaurant;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantAnswerController extends Controller
{
    /**
     * Wyświetl formularz do edycji dopasowań odpowiedzi dla restauracji
     */
    public function edit(Restaurant $restaurant)
    {
        // Pobierz wszystkie pytania z odpowiedziami
        $questions = Question::with('answers')->get();
        
        // Pobierz aktualne dopasowania dla restauracji
        $currentMatches = $restaurant->answers()
            ->get()
            ->pluck('pivot.relevance_score', 'id')
            ->toArray();
        
        return view('admin.restaurants.answers', [
            'restaurant' => $restaurant,
            'questions' => $questions,
            'currentMatches' => $currentMatches
        ]);
    }

    /**
     * Aktualizuj dopasowania odpowiedzi dla restauracji
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $matches = $request->input('matches', []);
        
        // Aktualizuj dopasowania
        foreach ($matches as $answerId => $score) {
            // Sprawdź, czy odpowiedź istnieje
            $answer = Answer::find($answerId);
            if (!$answer) {
                continue;
            }
            
            // Aktualizuj lub utwórz powiązanie
            $restaurant->answers()->syncWithoutDetaching([
                $answerId => ['relevance_score' => (int)$score]
            ]);
        }
        
        // Przelicz i zaktualizuj ogólny poziom dopasowania restauracji
        $this->updateOverallMatchScore($restaurant);
        
        return redirect()->route('admin.restaurants.answers.edit', $restaurant->id)
            ->with('message', 'Dopasowania zostały zaktualizowane pomyślnie.');
    }
    
    /**
     * Przelicz i zaktualizuj ogólny poziom dopasowania restauracji
     */
    private function updateOverallMatchScore(Restaurant $restaurant)
    {
        // Pobierz wszystkie dopasowania dla restauracji
        $matches = $restaurant->answers()
            ->get(['answers.id', 'relevance_score', 'question_id']);
        
        if ($matches->isEmpty()) {
            return;
        }
        
        // Grupuj odpowiedzi według pytań i oblicz średnią ocenę dla każdego pytania
        $questionScores = [];
        foreach ($matches as $match) {
            $questionId = $match->question_id;
            if (!isset($questionScores[$questionId])) {
                $questionScores[$questionId] = ['sum' => 0, 'count' => 0];
            }
            $questionScores[$questionId]['sum'] += $match->pivot->relevance_score;
            $questionScores[$questionId]['count']++;
        }
        
        // Oblicz średnią ocenę dla każdego pytania
        $totalScore = 0;
        $questionCount = 0;
        foreach ($questionScores as $scores) {
            if ($scores['count'] > 0) {
                $totalScore += $scores['sum'] / $scores['count'];
                $questionCount++;
            }
        }
        
        // Oblicz ogólną ocenę dopasowania (skala 0-5)
        $overallScore = 0;
        if ($questionCount > 0) {
            // Przelicz z skali 0-10 na skalę 0-5
            $overallScore = ($totalScore / $questionCount) * 0.5;
        }
        
        // Zaktualizuj restaurację
        $restaurant->match_score = $overallScore;
        $restaurant->save();
    }
}
