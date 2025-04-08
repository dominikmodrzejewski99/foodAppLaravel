<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchingController extends Controller
{
    /**
     * Oblicz dopasowanie restauracji na podstawie wybranych odpowiedzi użytkownika
     */
    public function calculateMatching(Request $request)
    {
        $validated = $request->validate([
            'answer_ids' => 'required|array',
            'answer_ids.*' => 'integer|exists:answers,id',
        ]);

        $answerIds = $validated['answer_ids'];

        // Pobierz wszystkie restauracje z ich dopasowaniami do wybranych odpowiedzi
        $restaurants = Restaurant::with(['answers' => function($query) use ($answerIds) {
            $query->whereIn('answers.id', $answerIds);
        }])->get();

        // Oblicz dopasowanie dla każdej restauracji
        $matchedRestaurants = $restaurants->map(function ($restaurant) use ($answerIds) {
            // Pobierz dopasowania dla wybranych odpowiedzi
            $matches = $restaurant->answers->whereIn('id', $answerIds);
            
            // Jeśli nie ma dopasowań, zwróć 0
            if ($matches->isEmpty()) {
                $restaurant->matching_score = 0;
                return $restaurant;
            }
            
            // Oblicz średnią ocenę dopasowania
            $totalScore = 0;
            foreach ($matches as $match) {
                $totalScore += $match->pivot->relevance_score;
            }
            
            // Oblicz procentowe dopasowanie (0-100%)
            $matchingScore = ($totalScore / (count($answerIds) * 10)) * 100;
            
            // Dodaj wynik dopasowania do obiektu restauracji
            $restaurant->matching_score = round($matchingScore);
            
            return $restaurant;
        });

        // Posortuj restauracje według wyniku dopasowania (od najwyższego do najniższego)
        $sortedRestaurants = $matchedRestaurants->sortByDesc('matching_score')->values();

        return response()->json([
            'restaurants' => $sortedRestaurants
        ]);
    }
}
