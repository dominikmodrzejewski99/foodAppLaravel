<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Polls",
 *     description="API Endpoints for Polls"
 * )
 */
class PollController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/questions",
     *     summary="Get list of questions",
     *     tags={"Polls"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="question_text", type="string", example="What is your favorite cuisine?"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function getQuestions()
    {
        $questions = DB::table('questions')->get();
        return response()->json($questions);
    }

    /**
     * @OA\Get(
     *     path="/api/answers",
     *     summary="Get list of answers",
     *     tags={"Polls"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="question_id", type="integer", example=1),
     *                 @OA\Property(property="answer_text", type="string", example="Italian"),
     *                 @OA\Property(property="votes", type="integer", example=42),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function getAnswers()
    {
        $answers = DB::table('answers')->get();
        return response()->json($answers);
    }
}
