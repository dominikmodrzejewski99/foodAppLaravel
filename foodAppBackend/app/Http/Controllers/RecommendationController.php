<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Restaurant;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Recommendations",
 *     description="API Endpoints for Restaurant Recommendations"
 * )
 */
class RecommendationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/recommendations",
     *     summary="Get restaurant recommendations based on user answers",
     *     tags={"Recommendations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1, description="Optional user ID"),
     *             @OA\Property(property="session_id", type="string", example="abc123", description="Session ID for non-authenticated users"),
     *             @OA\Property(property="answers", type="array", @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="question_id", type="integer", example=1),
     *                 @OA\Property(property="answer_id", type="integer", example=3)
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="recommendations", type="array", @OA\Items(ref="#/components/schemas/Restaurant")),
     *             @OA\Property(property="score", type="number", example=85.5, description="Match score percentage")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function getRecommendations(Request $request)
    {
        // Walidacja danych wejściowych
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer|exists:users,id',
            'session_id' => 'nullable|string',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.answer_id' => 'required|integer|exists:answers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Zapisz odpowiedzi użytkownika, jeśli potrzeba
        $userId = $request->input('user_id');
        $sessionId = $request->input('session_id');
        $userAnswers = $request->input('answers');

        // Pobierz ID odpowiedzi
        $answerIds = collect($userAnswers)->pluck('answer_id')->toArray();

        // Znajdź restauracje powiązane z tymi odpowiedziami
        $restaurantScores = [];

        // Pobierz wszystkie odpowiedzi z ich powiązanymi restauracjami
        $answers = Answer::with('restaurants')
            ->whereIn('id', $answerIds)
            ->get();

        // Oblicz wyniki dla każdej restauracji
        foreach ($answers as $answer) {
            // Pobierz pytanie, aby uwzględnić jego wagę
            $question = Question::find($answer->question_id);
            $questionWeight = $question->weight ?? 1;

            foreach ($answer->restaurants as $restaurant) {
                $relevanceScore = $restaurant->pivot->relevance_score;

                // Oblicz wynik dla tej restauracji (waga pytania * istotność odpowiedzi)
                $score = $questionWeight * $relevanceScore;

                // Dodaj lub zaktualizuj wynik restauracji
                if (!isset($restaurantScores[$restaurant->id])) {
                    $restaurantScores[$restaurant->id] = [
                        'restaurant' => $restaurant,
                        'score' => 0,
                        'matches' => 0,
                    ];
                }

                $restaurantScores[$restaurant->id]['score'] += $score;
                $restaurantScores[$restaurant->id]['matches']++;
            }
        }

        // Sortuj restauracje według wyniku (od najwyższego do najniższego)
        usort($restaurantScores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Wybierz top 5 restauracji
        $topRestaurants = array_slice($restaurantScores, 0, 5);

        // Przygotuj odpowiedź
        $recommendations = [];
        $maxPossibleScore = count($answerIds) * 10; // Maksymalny możliwy wynik (zakładając, że każde pytanie ma wagę 1 i maksymalny relevance_score to 10)

        foreach ($topRestaurants as $restaurantData) {
            $restaurant = $restaurantData['restaurant'];
            $score = $restaurantData['score'];
            $matchPercentage = ($maxPossibleScore > 0) ? round(($score / $maxPossibleScore) * 100, 1) : 0;

            $recommendations[] = [
                'restaurant' => $restaurant,
                'match_score' => $matchPercentage,
                'matches' => $restaurantData['matches'],
            ];
        }

        return response()->json([
            'recommendations' => $recommendations,
        ]);
    }
}
