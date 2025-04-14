<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant;
use App\Models\Answer;

class UpdateAllMatches extends Command
{
    protected $signature = 'update:all-matches';
    protected $description = 'Aktualizuje wartości dopasowań dla wszystkich restauracji w bazie danych';

    public function handle()
    {
        // Pobierz wszystkie restauracje
        $restaurants = Restaurant::all();
        
        if ($restaurants->isEmpty()) {
            $this->error('Nie znaleziono żadnych restauracji w bazie danych');
            return;
        }
        
        $this->info('Znaleziono ' . $restaurants->count() . ' restauracji');
        
        // Pobierz wszystkie odpowiedzi
        $answers = Answer::all();
        
        // Dla każdej restauracji
        foreach ($restaurants as $restaurant) {
            $this->info('Aktualizuję dopasowania dla restauracji: ' . $restaurant->name);
            
            // Usuń istniejące dopasowania
            $restaurant->answers()->detach();
            
            // Utwórz nowe dopasowania na podstawie profilu restauracji
            $matches = $this->getMatchesForRestaurant($restaurant);
            
            // Dodaj nowe dopasowania
            foreach ($answers as $answer) {
                if (isset($matches[$answer->answer_text])) {
                    $restaurant->answers()->attach($answer->id, [
                        'relevance_score' => $matches[$answer->answer_text],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    // Domyślna wartość dla odpowiedzi, które nie mają określonej wartości
                    $defaultValue = 0;
                    
                    // Specjalne przypadki
                    if ($answer->answer_text === 'Jest mi to obojętne' || $answer->answer_text === 'Nie liczę się z kosztami') {
                        $defaultValue = 10;
                    }
                    
                    $restaurant->answers()->attach($answer->id, [
                        'relevance_score' => $defaultValue,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        $this->info('Zakończono aktualizację dopasowań dla wszystkich restauracji');
    }
    
    /**
     * Zwraca wartości dopasowań dla danej restauracji na podstawie jej profilu
     */
    private function getMatchesForRestaurant(Restaurant $restaurant)
    {
        // Domyślne wartości dla wszystkich restauracji
        $defaultMatches = [
            // Specjalne przypadki
            'Jest mi to obojętne' => 10,
            'Nie liczę się z kosztami' => 10,
        ];
        
        // Wartości dopasowań dla różnych typów restauracji
        $matchesByType = [
            // Żeberka! (Polska, BBQ)
            'Żeberka!' => [
                // Z kim wybierasz się do restauracji?
                'Sam/a' => 6,
                'Z drugą połówką' => 7,
                'Ze znajomymi' => 10,
                'Z rodziną' => 9,
                
                // Jaki masz budżet na osobę?
                'Do 30 zł' => 5,
                '30–60 zł' => 9,
                '60–100 zł' => 7,
                
                // O jakiej porze planujesz wizytę?
                'Śniadanie' => 1,
                'Lunch' => 7,
                'Obiad' => 10,
                'Kolacja' => 9,
                
                // Jaki jest cel Twojej wizyty?
                'Spotkanie towarzyskie' => 10,
                'Świętowanie (urodziny, rocznica itp.)' => 8,
                'Spotkanie biznesowe' => 4,
                'Randka' => 6,
                
                // Jakiego klimatu szukasz?
                'Kameralnie i romantycznie' => 4,
                'Swobodnie i na luzie' => 10,
                'Nowocześnie i designersko' => 6,
                'Elegancko i z klasą' => 3,
                
                // Jakie doświadczenie kulinarne Cię interesuje?
                'Coś zaskakującego' => 6,
                'Smaki kuchni zagranicznej' => 3,
                'Tradycyjnie i lokalne smaki' => 10,
                'Fine dining – degustacja i forma' => 2,
                
                // Jakie dodatki są dla Ciebie ważne?
                'Oferta barowa' => 8,
                'Ogródek / taras' => 6,
                'Ciekawa lokalizacja (np. z ładnym widokiem)' => 5,
                'Wygodne miejsce, np. do pracy' => 3,
                
                // Na ile ważna jest cisza i prywatność?
                'Bardzo ważna – chcę spokoju' => 3,
                'Umiarkowanie' => 6,
                'Lubię miejsca tętniące życiem' => 9,
            ],
            
            // Ato Ramen (Japońska, Ramen)
            'Ato Ramen' => [
                // Z kim wybierasz się do restauracji?
                'Sam/a' => 9,
                'Z drugą połówką' => 8,
                'Ze znajomymi' => 9,
                'Z rodziną' => 6,
                
                // Jaki masz budżet na osobę?
                'Do 30 zł' => 3,
                '30–60 zł' => 9,
                '60–100 zł' => 7,
                
                // O jakiej porze planujesz wizytę?
                'Śniadanie' => 2,
                'Lunch' => 9,
                'Obiad' => 9,
                'Kolacja' => 8,
                
                // Jaki jest cel Twojej wizyty?
                'Spotkanie towarzyskie' => 9,
                'Świętowanie (urodziny, rocznica itp.)' => 6,
                'Spotkanie biznesowe' => 5,
                'Randka' => 7,
                
                // Jakiego klimatu szukasz?
                'Kameralnie i romantycznie' => 5,
                'Swobodnie i na luzie' => 9,
                'Nowocześnie i designersko' => 8,
                'Elegancko i z klasą' => 4,
                
                // Jakie doświadczenie kulinarne Cię interesuje?
                'Coś zaskakującego' => 7,
                'Smaki kuchni zagranicznej' => 10,
                'Tradycyjnie i lokalne smaki' => 2,
                'Fine dining – degustacja i forma' => 3,
                
                // Jakie dodatki są dla Ciebie ważne?
                'Oferta barowa' => 6,
                'Ogródek / taras' => 4,
                'Ciekawa lokalizacja (np. z ładnym widokiem)' => 7,
                'Wygodne miejsce, np. do pracy' => 5,
                
                // Na ile ważna jest cisza i prywatność?
                'Bardzo ważna – chcę spokoju' => 4,
                'Umiarkowanie' => 7,
                'Lubię miejsca tętniące życiem' => 8,
            ],
            
            // Culto (Fusion, Burgers)
            'Culto' => [
                // Z kim wybierasz się do restauracji?
                'Sam/a' => 7,
                'Z drugą połówką' => 8,
                'Ze znajomymi' => 10,
                'Z rodziną' => 8,
                
                // Jaki masz budżet na osobę?
                'Do 30 zł' => 4,
                '30–60 zł' => 8,
                '60–100 zł' => 9,
                
                // O jakiej porze planujesz wizytę?
                'Śniadanie' => 3,
                'Lunch' => 8,
                'Obiad' => 9,
                'Kolacja' => 9,
                
                // Jaki jest cel Twojej wizyty?
                'Spotkanie towarzyskie' => 10,
                'Świętowanie (urodziny, rocznica itp.)' => 8,
                'Spotkanie biznesowe' => 6,
                'Randka' => 8,
                
                // Jakiego klimatu szukasz?
                'Kameralnie i romantycznie' => 6,
                'Swobodnie i na luzie' => 10,
                'Nowocześnie i designersko' => 9,
                'Elegancko i z klasą' => 5,
                
                // Jakie doświadczenie kulinarne Cię interesuje?
                'Coś zaskakującego' => 8,
                'Smaki kuchni zagranicznej' => 8,
                'Tradycyjnie i lokalne smaki' => 5,
                'Fine dining – degustacja i forma' => 4,
                
                // Jakie dodatki są dla Ciebie ważne?
                'Oferta barowa' => 9,
                'Ogródek / taras' => 7,
                'Ciekawa lokalizacja (np. z ładnym widokiem)' => 8,
                'Wygodne miejsce, np. do pracy' => 5,
                
                // Na ile ważna jest cisza i prywatność?
                'Bardzo ważna – chcę spokoju' => 3,
                'Umiarkowanie' => 6,
                'Lubię miejsca tętniące życiem' => 9,
            ],
        ];
        
        // Jeśli mamy predefiniowane wartości dla tej restauracji, użyj ich
        if (isset($matchesByType[$restaurant->name])) {
            return array_merge($defaultMatches, $matchesByType[$restaurant->name]);
        }
        
        // W przeciwnym razie, określ wartości na podstawie kuchni
        $matches = $defaultMatches;
        
        // Analizuj kuchnię restauracji
        $cuisine = strtolower($restaurant->cuisine);
        
        // Z kim wybierasz się do restauracji?
        if (strpos($cuisine, 'polska') !== false || strpos($cuisine, 'bbq') !== false) {
            $matches['Sam/a'] = 6;
            $matches['Z drugą połówką'] = 7;
            $matches['Ze znajomymi'] = 9;
            $matches['Z rodziną'] = 8;
        } elseif (strpos($cuisine, 'japońska') !== false || strpos($cuisine, 'ramen') !== false || strpos($cuisine, 'sushi') !== false) {
            $matches['Sam/a'] = 8;
            $matches['Z drugą połówką'] = 8;
            $matches['Ze znajomymi'] = 8;
            $matches['Z rodziną'] = 6;
        } elseif (strpos($cuisine, 'fusion') !== false || strpos($cuisine, 'burger') !== false) {
            $matches['Sam/a'] = 7;
            $matches['Z drugą połówką'] = 8;
            $matches['Ze znajomymi'] = 9;
            $matches['Z rodziną'] = 7;
        } elseif (strpos($cuisine, 'włoska') !== false || strpos($cuisine, 'pizza') !== false) {
            $matches['Sam/a'] = 6;
            $matches['Z drugą połówką'] = 8;
            $matches['Ze znajomymi'] = 9;
            $matches['Z rodziną'] = 9;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Sam/a'] = 7;
            $matches['Z drugą połówką'] = 7;
            $matches['Ze znajomymi'] = 8;
            $matches['Z rodziną'] = 7;
        }
        
        // Jaki masz budżet na osobę?
        if (strpos($cuisine, 'fast') !== false || strpos($cuisine, 'kebab') !== false) {
            $matches['Do 30 zł'] = 9;
            $matches['30–60 zł'] = 6;
            $matches['60–100 zł'] = 3;
        } elseif (strpos($cuisine, 'fine dining') !== false || strpos($cuisine, 'elegancka') !== false) {
            $matches['Do 30 zł'] = 1;
            $matches['30–60 zł'] = 3;
            $matches['60–100 zł'] = 8;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Do 30 zł'] = 5;
            $matches['30–60 zł'] = 8;
            $matches['60–100 zł'] = 6;
        }
        
        // O jakiej porze planujesz wizytę?
        if (strpos($cuisine, 'śniadaniowa') !== false || strpos($cuisine, 'kawiarnia') !== false) {
            $matches['Śniadanie'] = 9;
            $matches['Lunch'] = 7;
            $matches['Obiad'] = 4;
            $matches['Kolacja'] = 3;
        } elseif (strpos($cuisine, 'bar') !== false || strpos($cuisine, 'pub') !== false) {
            $matches['Śniadanie'] = 2;
            $matches['Lunch'] = 6;
            $matches['Obiad'] = 7;
            $matches['Kolacja'] = 9;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Śniadanie'] = 4;
            $matches['Lunch'] = 7;
            $matches['Obiad'] = 8;
            $matches['Kolacja'] = 7;
        }
        
        // Jaki jest cel Twojej wizyty?
        if (strpos($cuisine, 'elegancka') !== false || strpos($cuisine, 'fine dining') !== false) {
            $matches['Spotkanie towarzyskie'] = 6;
            $matches['Świętowanie (urodziny, rocznica itp.)'] = 9;
            $matches['Spotkanie biznesowe'] = 8;
            $matches['Randka'] = 9;
        } elseif (strpos($cuisine, 'fast') !== false || strpos($cuisine, 'kebab') !== false) {
            $matches['Spotkanie towarzyskie'] = 7;
            $matches['Świętowanie (urodziny, rocznica itp.)'] = 4;
            $matches['Spotkanie biznesowe'] = 3;
            $matches['Randka'] = 4;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Spotkanie towarzyskie'] = 8;
            $matches['Świętowanie (urodziny, rocznica itp.)'] = 7;
            $matches['Spotkanie biznesowe'] = 6;
            $matches['Randka'] = 7;
        }
        
        // Jakiego klimatu szukasz?
        if (strpos($cuisine, 'elegancka') !== false || strpos($cuisine, 'fine dining') !== false) {
            $matches['Kameralnie i romantycznie'] = 8;
            $matches['Swobodnie i na luzie'] = 4;
            $matches['Nowocześnie i designersko'] = 7;
            $matches['Elegancko i z klasą'] = 9;
        } elseif (strpos($cuisine, 'pub') !== false || strpos($cuisine, 'bar') !== false) {
            $matches['Kameralnie i romantycznie'] = 4;
            $matches['Swobodnie i na luzie'] = 9;
            $matches['Nowocześnie i designersko'] = 6;
            $matches['Elegancko i z klasą'] = 3;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Kameralnie i romantycznie'] = 6;
            $matches['Swobodnie i na luzie'] = 7;
            $matches['Nowocześnie i designersko'] = 6;
            $matches['Elegancko i z klasą'] = 5;
        }
        
        // Jakie doświadczenie kulinarne Cię interesuje?
        if (strpos($cuisine, 'polska') !== false) {
            $matches['Coś zaskakującego'] = 5;
            $matches['Smaki kuchni zagranicznej'] = 3;
            $matches['Tradycyjnie i lokalne smaki'] = 9;
            $matches['Fine dining – degustacja i forma'] = 4;
        } elseif (strpos($cuisine, 'japońska') !== false || strpos($cuisine, 'włoska') !== false || strpos($cuisine, 'tajska') !== false) {
            $matches['Coś zaskakującego'] = 7;
            $matches['Smaki kuchni zagranicznej'] = 9;
            $matches['Tradycyjnie i lokalne smaki'] = 3;
            $matches['Fine dining – degustacja i forma'] = 5;
        } elseif (strpos($cuisine, 'fusion') !== false) {
            $matches['Coś zaskakującego'] = 9;
            $matches['Smaki kuchni zagranicznej'] = 8;
            $matches['Tradycyjnie i lokalne smaki'] = 4;
            $matches['Fine dining – degustacja i forma'] = 6;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Coś zaskakującego'] = 6;
            $matches['Smaki kuchni zagranicznej'] = 6;
            $matches['Tradycyjnie i lokalne smaki'] = 6;
            $matches['Fine dining – degustacja i forma'] = 5;
        }
        
        // Jakie dodatki są dla Ciebie ważne?
        if (strpos($cuisine, 'pub') !== false || strpos($cuisine, 'bar') !== false) {
            $matches['Oferta barowa'] = 9;
            $matches['Ogródek / taras'] = 7;
            $matches['Ciekawa lokalizacja (np. z ładnym widokiem)'] = 6;
            $matches['Wygodne miejsce, np. do pracy'] = 4;
        } elseif (strpos($cuisine, 'kawiarnia') !== false) {
            $matches['Oferta barowa'] = 6;
            $matches['Ogródek / taras'] = 7;
            $matches['Ciekawa lokalizacja (np. z ładnym widokiem)'] = 7;
            $matches['Wygodne miejsce, np. do pracy'] = 9;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Oferta barowa'] = 7;
            $matches['Ogródek / taras'] = 6;
            $matches['Ciekawa lokalizacja (np. z ładnym widokiem)'] = 7;
            $matches['Wygodne miejsce, np. do pracy'] = 5;
        }
        
        // Na ile ważna jest cisza i prywatność?
        if (strpos($cuisine, 'elegancka') !== false || strpos($cuisine, 'fine dining') !== false) {
            $matches['Bardzo ważna – chcę spokoju'] = 8;
            $matches['Umiarkowanie'] = 7;
            $matches['Lubię miejsca tętniące życiem'] = 4;
        } elseif (strpos($cuisine, 'pub') !== false || strpos($cuisine, 'bar') !== false) {
            $matches['Bardzo ważna – chcę spokoju'] = 3;
            $matches['Umiarkowanie'] = 5;
            $matches['Lubię miejsca tętniące życiem'] = 9;
        } else {
            // Domyślne wartości dla innych kuchni
            $matches['Bardzo ważna – chcę spokoju'] = 5;
            $matches['Umiarkowanie'] = 7;
            $matches['Lubię miejsca tętniące życiem'] = 6;
        }
        
        return $matches;
    }
}
