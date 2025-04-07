<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Panel administracyjny dla restauracji (Inertia.js)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantAdminController::class)->except(['show']);
    });
});

// Panel administracyjny dla restauracji (Blade)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('restaurants/blade', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'index'])->name('restaurants.blade.index');
    Route::get('restaurants/blade/create', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'create'])->name('restaurants.blade.create');
    Route::post('restaurants/blade', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'store'])->name('restaurants.blade.store');
    Route::get('restaurants/blade/{restaurant}/edit', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'edit'])->name('restaurants.blade.edit');
    Route::put('restaurants/blade/{restaurant}', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'update'])->name('restaurants.blade.update');
    Route::delete('restaurants/blade/{restaurant}', [\App\Http\Controllers\Admin\RestaurantAdminBladeController::class, 'destroy'])->name('restaurants.blade.destroy');
});
