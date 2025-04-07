<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Question",
 *     required={"question_text"},
 *     @OA\Property(property="id", type="integer", format="int64", description="Question ID", example=1),
 *     @OA\Property(property="question_text", type="string", description="Question text", example="What is your favorite cuisine?"),
 *     @OA\Property(property="category", type="string", description="Question category", example="Food Preferences"),
 *     @OA\Property(property="weight", type="integer", description="Importance weight for recommendation algorithm", example=2),
 *     @OA\Property(property="is_active", type="boolean", description="Whether the question is active", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date")
 * )
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_text',
        'category',
        'weight',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the answers for the question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
