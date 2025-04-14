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

        // Pobierz wszystkie odpowiedzi
        $allAnswers = Answer::all();

        // Ustaw domyślne wartości dla odpowiedzi, które nie mają jeszcze dopasowania
        foreach ($allAnswers as $answer) {
            if (!isset($currentMatches[$answer->id])) {
                // Ustaw 10 dla odpowiedzi "Jest mi to obojętne" i "Nie liczę się z kosztami", 0 dla pozostałych
                if ($answer->answer_text === 'Jest mi to obojętne' || $answer->answer_text === 'Nie liczę się z kosztami') {
                    $currentMatches[$answer->id] = 10;
                } else {
                    $currentMatches[$answer->id] = 0;
                }
            }
        }

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

        // Nie przeliczamy już ogólnego poziomu dopasowania restauracji
        // Dopasowania są przechowywane per odpowiedź i obliczane dynamicznie po stronie frontendu

        return redirect()->route('admin.restaurants.answers.edit', $restaurant->id)
            ->with('message', 'Dopasowania zostały zaktualizowane pomyślnie.');
    }

    /**
     * Przelicz i zaktualizuj ogólny poziom dopasowania restauracji
     *
     * Uwaga: Ta metoda nie jest już używana, ponieważ dopasowania są przechowywane per odpowiedź
     * i obliczane dynamicznie po stronie frontendu na podstawie wybranych odpowiedzi użytkownika.
     */
    private function updateOverallMatchScore(Restaurant $restaurant)
    {
        // Ta metoda jest pozostawiona dla kompatybilności wstecznej, ale nie jest już używana
        // Dopasowania są przechowywane per odpowiedź w tabeli answer_restaurant
        // i obliczane dynamicznie po stronie frontendu na podstawie wybranych odpowiedzi użytkownika
    }
}
