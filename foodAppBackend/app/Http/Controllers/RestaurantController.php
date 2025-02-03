<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        return response()->json(Restaurant::all());
    }

    public function store(Request $request)
    {
        $restaurant = Restaurant::create($request->all());
        return response()->json($restaurant, 201);
    }

    public function show($id)
    {
        return response()->json(Restaurant::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update($request->all());
        return response()->json($restaurant);
    }

    public function destroy($id)
    {
        Restaurant::findOrFail($id)->delete();
        return response()->json(['message' => 'Restaurant deleted']);
    }
}
