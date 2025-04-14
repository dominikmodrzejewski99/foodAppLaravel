<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant;
use App\Models\Answer;

class UpdateMatches extends Command
{
    protected $signature = 'update:matches';
    protected $description = 'Aktualizuje wartości dopasowań dla restauracji Ato Ramen i Culto';

    public function handle()
    {
        // Znajdź restauracje
        $atoRamen = Restaurant::where('name', 'Ato Ramen')->first();
        $culto = Restaurant::where('name', 'Culto')->first();

        if (!$atoRamen) {
            $this->error('Nie znaleziono restauracji Ato Ramen');
            return;
        }

        if (!$culto) {
            $this->error('Nie znaleziono restauracji Culto');
            return;
        }

        // Wartości dopasowań dla Ato Ramen
        $atoRamenMatches = [
            // Z kim wybierasz się do restauracji?
            'Sam/a' => 9,
            'Z drugą połówką' => 8,
            'Ze znajomymi' => 9,
            'Z rodziną' => 6,
            
            // Jaki masz budżet na osobę?
            'Do 30 zł' => 3,
            '30–60 zł' => 9,
            '60–100 zł' => 7,
            'Nie liczę się z kosztami' => 10,
            
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
            'Jest mi to obojętne' => 10,
        ];
        
        // Wartości dopasowań dla Culto
        $cultoMatches = [
            // Z kim wybierasz się do restauracji?
            'Sam/a' => 7,
            'Z drugą połówką' => 8,
            'Ze znajomymi' => 10,
            'Z rodziną' => 8,
            
            // Jaki masz budżet na osobę?
            'Do 30 zł' => 4,
            '30–60 zł' => 8,
            '60–100 zł' => 9,
            'Nie liczę się z kosztami' => 10,
            
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
            'Jest mi to obojętne' => 10,
        ];

        // Funkcja do aktualizacji dopasowań dla restauracji
        $updateMatches = function ($restaurant, $matches) {
            // Usuń istniejące dopasowania
            $restaurant->answers()->detach();
            
            // Dodaj nowe dopasowania
            $answers = Answer::all();
            foreach ($answers as $answer) {
                if (isset($matches[$answer->answer_text])) {
                    $restaurant->answers()->attach($answer->id, [
                        'relevance_score' => $matches[$answer->answer_text],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        };

        // Aktualizuj dopasowania dla Ato Ramen
        $updateMatches($atoRamen, $atoRamenMatches);
        $this->info('Zaktualizowano dopasowania dla Ato Ramen');

        // Aktualizuj dopasowania dla Culto
        $updateMatches($culto, $cultoMatches);
        $this->info('Zaktualizowano dopasowania dla Culto');
    }
}
