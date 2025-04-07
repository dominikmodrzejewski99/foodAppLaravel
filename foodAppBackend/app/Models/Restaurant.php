<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
