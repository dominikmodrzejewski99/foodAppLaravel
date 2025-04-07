<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     schema="Answer",
 *     required={"answer_text", "question_id"},
 *     @OA\Property(property="id", type="integer", format="int64", description="Answer ID", example=1),
 *     @OA\Property(property="question_id", type="integer", format="int64", description="Question ID", example=1),
 *     @OA\Property(property="answer_text", type="string", description="Answer text", example="Italian"),
 *     @OA\Property(property="cuisine_tags", type="array", @OA\Items(type="string"), description="Cuisine tags"),
 *     @OA\Property(property="price_range", type="array", @OA\Items(type="number"), description="Price range"),
 *     @OA\Property(property="score", type="integer", description="Score for recommendation algorithm", example=5),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date")
 * )
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'answer_text',
        'cuisine_tags',
        'price_range',
        'score',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cuisine_tags' => 'array',
        'price_range' => 'array',
    ];

    /**
     * Get the question that owns the answer.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * The restaurants that are associated with this answer.
     */
    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class)
            ->withPivot('relevance_score')
            ->withTimestamps();
    }
}
