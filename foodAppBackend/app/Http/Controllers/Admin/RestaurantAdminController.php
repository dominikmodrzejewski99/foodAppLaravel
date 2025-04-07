<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantAdminController extends Controller
{
    /**
     * Wyświetl listę restauracji
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Pokaż formularz tworzenia nowej restauracji
     */
    public function create()
    {
        return Inertia::render('Admin/Restaurants/Create');
    }

    /**
     * Zapisz nową restaurację
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'website' => 'nullable|string|max:255',
            'match_people_count' => 'required|integer|min:0|max:9',
            'match_price_per_person' => 'required|integer|min:0|max:9',
            'match_meal_type' => 'required|integer|min:0|max:9',
            'match_visit_purpose' => 'required|integer|min:0|max:9',
            'match_dietary_preferences' => 'required|integer|min:0|max:9',
        ]);

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('message', 'Restauracja została dodana pomyślnie.');
    }

    /**
     * Wyświetl szczegóły restauracji
     */
    public function show(Restaurant $restaurant)
    {
        return Inertia::render('Admin/Restaurants/Show', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Pokaż formularz edycji restauracji
     */
    public function edit(Restaurant $restaurant)
    {
        return Inertia::render('Admin/Restaurants/Edit', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Aktualizuj restaurację
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'website' => 'nullable|string|max:255',
            'match_people_count' => 'required|integer|min:0|max:9',
            'match_price_per_person' => 'required|integer|min:0|max:9',
            'match_meal_type' => 'required|integer|min:0|max:9',
            'match_visit_purpose' => 'required|integer|min:0|max:9',
            'match_dietary_preferences' => 'required|integer|min:0|max:9',
        ]);

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('message', 'Restauracja została zaktualizowana pomyślnie.');
    }

    /**
     * Usuń restaurację
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('message', 'Restauracja została usunięta pomyślnie.');
    }
}
