<?php

// Skrypt do aktualizacji wartości dopasowań dla restauracji Ato Ramen i Culto

// Połączenie z bazą danych
$host = 'localhost';
$dbname = 'foodApp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Znajdź ID restauracji Ato Ramen i Culto
    $stmt = $pdo->prepare("SELECT id, name FROM restaurants WHERE name IN ('Ato Ramen', 'Culto')");
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $restaurantIds = [];
    foreach ($restaurants as $restaurant) {
        $restaurantIds[$restaurant['name']] = $restaurant['id'];
    }
    
    // Pobierz wszystkie odpowiedzi
    $stmt = $pdo->prepare("SELECT id, answer_text, question_id FROM answers");
    $stmt->execute();
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Grupuj odpowiedzi według pytań
    $answersByQuestion = [];
    $answersById = [];
    foreach ($answers as $answer) {
        $answersByQuestion[$answer['question_id']][] = $answer;
        $answersById[$answer['id']] = $answer;
    }
    
    // Usuń istniejące dopasowania dla tych restauracji
    $stmt = $pdo->prepare("DELETE FROM answer_restaurant WHERE restaurant_id IN (?, ?)");
    $stmt->execute([$restaurantIds['Ato Ramen'], $restaurantIds['Culto']]);
    
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
    
    // Funkcja do dodawania dopasowań dla restauracji
    function addMatches($pdo, $restaurantId, $matches, $answersById) {
        $stmt = $pdo->prepare("INSERT INTO answer_restaurant (restaurant_id, answer_id, relevance_score, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        
        foreach ($answersById as $answerId => $answer) {
            if (isset($matches[$answer['answer_text']])) {
                $relevanceScore = $matches[$answer['answer_text']];
                $stmt->execute([$restaurantId, $answerId, $relevanceScore]);
            }
        }
    }
    
    // Dodaj dopasowania dla Ato Ramen
    if (isset($restaurantIds['Ato Ramen'])) {
        addMatches($pdo, $restaurantIds['Ato Ramen'], $atoRamenMatches, $answersById);
        echo "Zaktualizowano dopasowania dla Ato Ramen\n";
    } else {
        echo "Nie znaleziono restauracji Ato Ramen\n";
    }
    
    // Dodaj dopasowania dla Culto
    if (isset($restaurantIds['Culto'])) {
        addMatches($pdo, $restaurantIds['Culto'], $cultoMatches, $answersById);
        echo "Zaktualizowano dopasowania dla Culto\n";
    } else {
        echo "Nie znaleziono restauracji Culto\n";
    }
    
    echo "Zakończono aktualizację dopasowań\n";
    
} catch (PDOException $e) {
    echo "Błąd: " . $e->getMessage() . "\n";
}
