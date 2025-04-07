<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'cuisine',
        'rating',
        'website',
        'match_people_count',
        'match_price_per_person',
        'match_meal_type',
        'match_visit_purpose',
        'match_dietary_preferences'
    ];

    /**
     * The answers that are associated with this restaurant.
     */
    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class)
            ->withPivot('relevance_score')
            ->withTimestamps();
    }
}
