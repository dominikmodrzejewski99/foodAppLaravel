<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantAdminBladeController extends Controller
{
    /**
     * Wyświetl listę restauracji
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', [
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Pokaż formularz tworzenia nowej restauracji
     */
    public function create()
    {
        // Pobierz wszystkie pytania z odpowiedziami
        $questions = \App\Models\Question::with('answers')->get();

        return view('admin.restaurants.create', [
            'questions' => $questions
        ]);
    }

    /**
     * Zapisz nową restaurację
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'website' => 'nullable|string|max:255',
            'match_people_count' => 'required|integer|min:0|max:9',
            'match_price_per_person' => 'required|integer|min:0|max:9',
            'match_meal_type' => 'required|integer|min:0|max:9',
            'match_visit_purpose' => 'required|integer|min:0|max:9',
            'match_dietary_preferences' => 'required|integer|min:0|max:9',
            'answer_matches' => 'nullable|array',
            'answer_matches.*' => 'integer|min:0|max:10',
        ]);

        // Utwórz restaurację
        $restaurant = Restaurant::create($validated);

        // Pobierz wszystkie odpowiedzi
        $allAnswers = \App\Models\Answer::all();

        // Przygotuj domyślne wartości dopasowań
        $defaultMatches = [];
        foreach ($allAnswers as $answer) {
            if ($answer->answer_text === 'Jest mi to obojętne' || $answer->answer_text === 'Nie liczę się z kosztami') {
                $defaultMatches[$answer->id] = 10;
            } else {
                $defaultMatches[$answer->id] = 0;
            }
        }

        // Zapisz dopasowania odpowiedzi
        $answerMatches = $request->input('answer_matches', []);

        // Połącz domyślne wartości z wartościami z formularza
        $finalMatches = array_merge($defaultMatches, $answerMatches);

        // Pobierz wszystkie prawidłowe identyfikatory odpowiedzi
        $validAnswerIds = $allAnswers->pluck('id')->toArray();

        foreach ($finalMatches as $answerId => $relevanceScore) {
            // Upewnij się, że answerId jest prawidłowym identyfikatorem odpowiedzi
            if (in_array($answerId, $validAnswerIds)) {
                $restaurant->answers()->attach($answerId, [
                    'relevance_score' => $relevanceScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została dodana pomyślnie.');
    }

    /**
     * Pokaż formularz edycji restauracji
     */
    public function edit(Restaurant $restaurant)
    {
        // Pobierz wszystkie pytania z odpowiedziami
        $questions = \App\Models\Question::with('answers')->get();

        // Pobierz aktualne dopasowania odpowiedzi dla restauracji
        $restaurant->load('answers');

        // Przygotuj tablicę z aktualnymi wartościami dopasowań
        $currentMatches = [];
        foreach ($restaurant->answers as $answer) {
            $currentMatches[$answer->id] = $answer->pivot->relevance_score;
        }

        // Pobierz wszystkie odpowiedzi
        $allAnswers = \App\Models\Answer::all();

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

        return view('admin.restaurants.edit', [
            'restaurant' => $restaurant,
            'questions' => $questions,
            'currentMatches' => $currentMatches
        ]);
    }

    /**
     * Aktualizuj restaurację
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'website' => 'nullable|string|max:255',
            'match_people_count' => 'required|integer|min:0|max:9',
            'match_price_per_person' => 'required|integer|min:0|max:9',
            'match_meal_type' => 'required|integer|min:0|max:9',
            'match_visit_purpose' => 'required|integer|min:0|max:9',
            'match_dietary_preferences' => 'required|integer|min:0|max:9',
            'answer_matches' => 'nullable|array',
            'answer_matches.*' => 'integer|min:0|max:10',
        ]);

        // Aktualizuj restaurację
        $restaurant->update($validated);

        // Pobierz wszystkie odpowiedzi
        $allAnswers = \App\Models\Answer::all();

        // Przygotuj domyślne wartości dopasowań
        $defaultMatches = [];
        foreach ($allAnswers as $answer) {
            if ($answer->answer_text === 'Jest mi to obojętne' || $answer->answer_text === 'Nie liczę się z kosztami') {
                $defaultMatches[$answer->id] = 10;
            } else {
                $defaultMatches[$answer->id] = 0;
            }
        }

        // Zapisz dopasowania odpowiedzi
        $answerMatches = $request->input('answer_matches', []);

        // Połącz domyślne wartości z wartościami z formularza
        $finalMatches = array_merge($defaultMatches, $answerMatches);

        // Usuń wszystkie istniejące dopasowania
        $restaurant->answers()->detach();

        // Pobierz wszystkie prawidłowe identyfikatory odpowiedzi
        $validAnswerIds = $allAnswers->pluck('id')->toArray();

        // Dodaj nowe dopasowania
        foreach ($finalMatches as $answerId => $relevanceScore) {
            // Upewnij się, że answerId jest prawidłowym identyfikatorem odpowiedzi
            if (in_array($answerId, $validAnswerIds)) {
                $restaurant->answers()->attach($answerId, [
                    'relevance_score' => $relevanceScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została zaktualizowana pomyślnie.');
    }

    /**
     * Usuń restaurację
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została usunięta pomyślnie.');
    }
}
