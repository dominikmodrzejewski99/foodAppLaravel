<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('restaurants', RestaurantController::class);

Route::get('/questions', [PollController::class, 'getQuestions']);
Route::get('/answers', [PollController::class, 'getAnswers']);

// Trasa do obliczania dopasowania restauracji
Route::post('/matching', [\App\Http\Controllers\MatchingController::class, 'calculateMatching']);
