<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sprawdzamy, czy tabela answer_restaurant istnieje
        if (Schema::hasTable('answer_restaurant')) {
            // Usuwamy wszystkie powiązania z tabeli answer_restaurant
            DB::table('answer_restaurant')->delete();
        }

        // Usuwamy wszystkie restauracje
        // Nie możemy użyć truncate, ponieważ istnieje ograniczenie klucza obcego
        // Zamiast tego usuwamy wszystkie restauracje pojedynczo
        $existingRestaurants = Restaurant::all();
        foreach ($existingRestaurants as $restaurant) {
            $restaurant->answers()->detach(); // Usuwamy powiązania
            $restaurant->delete(); // Usuwamy restaurację
        }

        $restaurants = [
            [
                'name'     => 'Żeberka!',
                'address'  => 'ul. Świętego Antoniego 23, 50-073 Wrocław',
                'city'     => 'Wrocław',
                'cuisine'  => 'Polska, BBQ',
                'rating'   => 4.5,
                'website'  => 'https://www.zeberka.net',
            ],
            [
                'name'     => 'Ato Ramen',
                'address'  => 'ul. Odrzańska 17/1B, 50-113 Wrocław',
                'city'     => 'Wrocław',
                'cuisine'  => 'Japońska, Ramen',
                'rating'   => 4.7,
                'website'  => 'https://atoramen.pl',
            ],
            [
                'name'     => 'Culto',
                'address'  => 'pl. Kościuszki 6, 50-038 Wrocław',
                'city'     => 'Wrocław',
                'cuisine'  => 'Fusion, Burgers',
                'rating'   => 4.6,
                'website'  => 'https://www.culto.pl',
            ],
        ];

        // Dodanie losowych wartości dopasowania dla każdej restauracji
        foreach ($restaurants as $restaurant) {
            // Dodanie losowych wartości dopasowania dla każdej restauracji
            $restaurant['match_people_count'] = rand(0, 9);
            $restaurant['match_price_per_person'] = rand(0, 9);
            $restaurant['match_meal_type'] = rand(0, 9);
            $restaurant['match_visit_purpose'] = rand(0, 9);
            $restaurant['match_dietary_preferences'] = rand(0, 9);

            Restaurant::create($restaurant);
        }
    }
}
