<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date")
 * )
 */
class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'cuisine', 'rating', 'website'];
}
