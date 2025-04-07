<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     required={"name", "address", "city", "cuisine"},
 *     @OA\Property(property="id", type="integer", format="int64", description="Restaurant ID", example=1),
 *     @OA\Property(property="name", type="string", description="Restaurant name", example="Pizza Palace"),
 *     @OA\Property(property="address", type="string", description="Restaurant address", example="123 Main St"),
 *     @OA\Property(property="city", type="string", description="Restaurant city", example="New York"),
 *     @OA\Property(property="cuisine", type="string", description="Restaurant cuisine type", example="Italian"),
 *     @OA\Property(property="rating", type="number", format="float", description="Restaurant rating", example=4.5),
 *     @OA\Property(property="website", type="string", description="Restaurant website", example="https://pizzapalace.com"),
 *     @OA\Property(property="description", type="string", description="Restaurant description"),
 *     @OA\Property(property="image_url", type="string", description="Restaurant image URL"),
 *     @OA\Property(property="price_level", type="number", format="float", description="Price level from 1.0 to 5.0", example=3.5),
 *     @OA\Property(property="is_tiktok_recommended", type="boolean", description="Whether the restaurant is recommended on TikTok", example=false),
 *     @OA\Property(property="popularity_score", type="integer", description="Popularity score", example=85),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date")
 * )
 */
class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'cuisine',
        'rating',
        'website',
        'description',
        'image_url',
        'price_level',
        'is_tiktok_recommended',
        'popularity_score'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'float',
        'price_level' => 'float',
        'is_tiktok_recommended' => 'boolean',
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
