<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantAdminBladeController extends Controller
{
    /**
     * Wyświetl listę restauracji
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', [
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Pokaż formularz tworzenia nowej restauracji
     */
    public function create()
    {
        return view('admin.restaurants.create');
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

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została dodana pomyślnie.');
    }

    /**
     * Pokaż formularz edycji restauracji
     */
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', [
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

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została zaktualizowana pomyślnie.');
    }

    /**
     * Usuń restaurację
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.blade.index')
            ->with('message', 'Restauracja została usunięta pomyślnie.');
    }
}
