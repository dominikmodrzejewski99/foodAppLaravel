<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class MatchingController extends Controller
{
    /**
     * Oblicza dopasowanie restauracji do odpowiedzi użytkownika
     */
    public function calculateMatching(Request $request)
    {
        $validated = $request->validate([
            'people_count' => 'required|integer|min:0|max:3', // 0-3 odpowiada odpowiedziom: jedna, dwie, trzy, cztery i więcej
            'price_per_person' => 'required|integer|min:0|max:3', // 0-3 odpowiada odpowiedziom: Do 30 zł, 30-50 zł, 50-80 zł, kwota nie ma znaczenia
            'meal_type' => 'required|integer|min:0|max:4', // 0-4 odpowiada odpowiedziom: sniadanie, lunch, obiad, kolacja, deser
            'visit_purpose' => 'required|integer|min:0|max:4', // 0-4 odpowiada odpowiedziom: Spotkanie biznesowe, Świętowanie, Wydarzenie towarzyskie, Rodzinna uroczystość, Rekreacja
            'dietary_preferences' => 'required|integer|min:0|max:4', // 0-4 odpowiada odpowiedziom: Wegetariańska, Wegańska, Bezglutenowa, Bez laktozy, Brak preferencji
        ]);

        // Pobierz wszystkie restauracje
        $restaurants = Restaurant::all();

        // Oblicz dopasowanie dla każdej restauracji
        $matchedRestaurants = $restaurants->map(function ($restaurant) use ($validated) {
            // Oblicz dopasowanie dla każdego kryterium
            $peopleCountMatch = $this->calculateSingleMatch($restaurant->match_people_count, $validated['people_count'], 3);
            $priceMatch = $this->calculateSingleMatch($restaurant->match_price_per_person, $validated['price_per_person'], 3);
            $mealTypeMatch = $this->calculateSingleMatch($restaurant->match_meal_type, $validated['meal_type'], 4);
            $visitPurposeMatch = $this->calculateSingleMatch($restaurant->match_visit_purpose, $validated['visit_purpose'], 4);
            $dietaryMatch = $this->calculateSingleMatch($restaurant->match_dietary_preferences, $validated['dietary_preferences'], 4);

            // Oblicz całkowite dopasowanie (średnia ważona)
            $totalMatch = ($peopleCountMatch + $priceMatch + $mealTypeMatch + $visitPurposeMatch + $dietaryMatch) / 5;

            // Dodaj wynik dopasowania do obiektu restauracji
            $restaurant->matching_score = round($totalMatch * 100); // Wynik w procentach
            
            return $restaurant;
        });

        // Posortuj restauracje według wyniku dopasowania (od najwyższego do najniższego)
        $sortedRestaurants = $matchedRestaurants->sortByDesc('matching_score')->values();

        return response()->json([
            'restaurants' => $sortedRestaurants
        ]);
    }

    /**
     * Oblicza dopasowanie dla pojedynczego kryterium
     * 
     * @param int $restaurantValue Wartość dopasowania restauracji (0-9)
     * @param int $userChoice Wybór użytkownika (0-maxChoice)
     * @param int $maxChoice Maksymalna wartość wyboru użytkownika
     * @return float Wynik dopasowania (0-1)
     */
    private function calculateSingleMatch($restaurantValue, $userChoice, $maxChoice)
    {
        // Przekształć wartość restauracji (0-9) na skalę wyboru użytkownika (0-maxChoice)
        $scaledRestaurantValue = ($restaurantValue / 9) * $maxChoice;
        
        // Oblicz różnicę między wartościami (im mniejsza różnica, tym lepsze dopasowanie)
        $difference = abs($scaledRestaurantValue - $userChoice);
        
        // Oblicz maksymalną możliwą różnicę
        $maxDifference = $maxChoice;
        
        // Oblicz wynik dopasowania (1 - różnica/maksymalna różnica)
        // Im mniejsza różnica, tym wyższy wynik
        return 1 - ($difference / $maxDifference);
    }
}
