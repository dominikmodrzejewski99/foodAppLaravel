<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pobierz wszystkie odpowiedzi i restauracje
        $answers = Answer::all();
        $restaurants = Restaurant::all();

        // Przykładowe powiązania dla odpowiedzi dotyczących budżetu
        $budgetAnswers = $answers->filter(function ($answer) {
            return str_contains($answer->answer_text, 'zł');
        });

        foreach ($budgetAnswers as $answer) {
            // Dla odpowiedzi "Do 100 zł" przypisz restauracje z niższą ceną
            if (str_contains($answer->answer_text, 'Do 100 zł')) {
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    // Przypisz restauracje z niższą ceną (price_level < 2.5)
                    return $restaurant->price_level < 2.5;
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 8, // Wysoka istotność
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Od 100 zł do 200 zł" przypisz restauracje ze średnią ceną
            if (str_contains($answer->answer_text, 'Od 100 zł do 200 zł')) {
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    // Przypisz restauracje ze średnią ceną (price_level między 2.0 a 3.5)
                    return $restaurant->price_level >= 2.0 && $restaurant->price_level <= 3.5;
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 7, // Wysoka istotność
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Od 200 zł do 500 zł" przypisz restauracje z wyższą ceną
            if (str_contains($answer->answer_text, 'Od 200 zł do 500 zł')) {
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    // Przypisz restauracje z wyższą ceną (price_level między 3.0 a 4.5)
                    return $restaurant->price_level >= 3.0 && $restaurant->price_level <= 4.5;
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 7, // Wysoka istotność
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Powyżej 500 zł" przypisz restauracje z najwyższą ceną
            if (str_contains($answer->answer_text, 'Powyżej 500 zł')) {
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    // Przypisz restauracje z najwyższą ceną (price_level > 4.0)
                    return $restaurant->price_level > 4.0;
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 9, // Bardzo wysoka istotność
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Powiązania dla odpowiedzi dotyczących charakteru wizyty
        $visitTypeAnswers = $answers->filter(function ($answer) {
            return in_array($answer->answer_text, ['Romantyczny', 'Biznesowy', 'Przyjacielski', 'Rodzinny']);
        });

        foreach ($visitTypeAnswers as $answer) {
            // Dla odpowiedzi "Romantyczny" przypisz odpowiednie restauracje
            if ($answer->answer_text === 'Romantyczny') {
                // Restauracje odpowiednie na romantyczną kolację
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    return $restaurant->rating >= 4.5 &&
                           !str_contains(strtolower($restaurant->cuisine), 'kebab') &&
                           !str_contains(strtolower($restaurant->cuisine), 'fast') &&
                           $restaurant->price_level >= 2.5;
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 8,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Biznesowy" przypisz odpowiednie restauracje
            if ($answer->answer_text === 'Biznesowy') {
                // Restauracje odpowiednie na spotkanie biznesowe
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    return $restaurant->rating >= 4.3 &&
                           $restaurant->price_level >= 3.0 &&
                           !str_contains(strtolower($restaurant->cuisine), 'fast');
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 7,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Przyjacielski" przypisz odpowiednie restauracje
            if ($answer->answer_text === 'Przyjacielski') {
                // Restauracje odpowiednie na spotkanie ze znajomymi
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    return $restaurant->rating >= 4.0 &&
                           ($restaurant->price_level >= 1.5 && $restaurant->price_level <= 3.5);
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 8,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Dla odpowiedzi "Rodzinny" przypisz odpowiednie restauracje
            if ($answer->answer_text === 'Rodzinny') {
                // Restauracje odpowiednie dla rodzin z dziećmi
                $matchingRestaurants = $restaurants->filter(function ($restaurant) {
                    return $restaurant->rating >= 4.0 &&
                           ($restaurant->price_level >= 1.5 && $restaurant->price_level <= 3.0) &&
                           !str_contains(strtolower($restaurant->name), 'bar');
                });

                foreach ($matchingRestaurants as $restaurant) {
                    DB::table('answer_restaurant')->insert([
                        'answer_id' => $answer->id,
                        'restaurant_id' => $restaurant->id,
                        'relevance_score' => 7,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Dodatkowe powiązania dla restauracji z TikToka
        $tiktokRestaurants = $restaurants->filter(function ($restaurant) {
            return $restaurant->is_tiktok_recommended === 1;
        });

        // Znajdź odpowiedzi dotyczące liczby osób
        $guestCountAnswers = $answers->filter(function ($answer) {
            return str_contains($answer->answer_text, 'osoby') || str_contains($answer->answer_text, 'osób');
        });

        // Przypisz popularne restauracje z TikToka do odpowiedzi o liczbie osób
        foreach ($guestCountAnswers as $answer) {
            foreach ($tiktokRestaurants as $restaurant) {
                // Dla restauracji z TikToka dajemy wyższy współczynnik istotności
                $relevanceScore = 9;

                // Dla lodziarni obniżamy współczynnik, jeśli jest więcej niż 3 osoby
                if (str_contains(strtolower($restaurant->cuisine), 'lodziarnia') &&
                    (str_contains($answer->answer_text, 'cztery osoby') || str_contains($answer->answer_text, 'pięć osób'))) {
                    $relevanceScore = 5;
                }

                DB::table('answer_restaurant')->insert([
                    'answer_id' => $answer->id,
                    'restaurant_id' => $restaurant->id,
                    'relevance_score' => $relevanceScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
