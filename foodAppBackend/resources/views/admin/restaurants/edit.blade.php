<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edytuj Restaurację</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        header {
            background-color: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        .card-header {
            margin-bottom: 1.5rem;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input, select, textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: inherit;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background-color: #ef4444;
            color: white;
        }
        .btn-primary:hover {
            background-color: #dc2626;
        }
        .btn-secondary {
            background-color: #4b5563;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #374151;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .form-col {
            flex: 1;
        }
        .range-value {
            display: inline-block;
            margin-left: 0.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel Administracyjny Restauracji</h1>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edytuj Restaurację</h2>
            </div>

            <form action="{{ route('admin.restaurants.blade.update', $restaurant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="name">Nazwa</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $restaurant->name) }}" required>
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Adres</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $restaurant->address) }}" required>
                            @error('address')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="city">Miasto</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $restaurant->city) }}" required>
                            @error('city')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cuisine">Kuchnia</label>
                            <input type="text" id="cuisine" name="cuisine" value="{{ old('cuisine', $restaurant->cuisine) }}" required>
                            @error('cuisine')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rating">Ocena (0-5)</label>
                            <input type="number" id="rating" name="rating" value="{{ old('rating', $restaurant->rating) }}" min="0" max="5" step="0.1">
                            @error('rating')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website">Strona internetowa</label>
                            <input type="text" id="website" name="website" value="{{ old('website', $restaurant->website) }}">
                            @error('website')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-col">
                        <h3>Wartości dopasowania (0-9)</h3>

                        <div class="form-group">
                            <label for="match_people_count">Dopasowanie do ilości osób</label>
                            <div>
                                <input type="range" id="match_people_count" name="match_people_count" value="{{ old('match_people_count', $restaurant->match_people_count) }}" min="0" max="9" oninput="this.nextElementSibling.textContent = this.value">
                                <span class="range-value">{{ $restaurant->match_people_count }}</span>
                            </div>
                            @error('match_people_count')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="match_price_per_person">Dopasowanie do ceny na osobę</label>
                            <div>
                                <input type="range" id="match_price_per_person" name="match_price_per_person" value="{{ old('match_price_per_person', $restaurant->match_price_per_person) }}" min="0" max="9" oninput="this.nextElementSibling.textContent = this.value">
                                <span class="range-value">{{ $restaurant->match_price_per_person }}</span>
                            </div>
                            @error('match_price_per_person')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="match_meal_type">Dopasowanie do rodzaju posiłku</label>
                            <div>
                                <input type="range" id="match_meal_type" name="match_meal_type" value="{{ old('match_meal_type', $restaurant->match_meal_type) }}" min="0" max="9" oninput="this.nextElementSibling.textContent = this.value">
                                <span class="range-value">{{ $restaurant->match_meal_type }}</span>
                            </div>
                            @error('match_meal_type')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="match_visit_purpose">Dopasowanie do celu wizyty</label>
                            <div>
                                <input type="range" id="match_visit_purpose" name="match_visit_purpose" value="{{ old('match_visit_purpose', $restaurant->match_visit_purpose) }}" min="0" max="9" oninput="this.nextElementSibling.textContent = this.value">
                                <span class="range-value">{{ $restaurant->match_visit_purpose }}</span>
                            </div>
                            @error('match_visit_purpose')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="match_dietary_preferences">Dopasowanie do preferencji dietetycznych</label>
                            <div>
                                <input type="range" id="match_dietary_preferences" name="match_dietary_preferences" value="{{ old('match_dietary_preferences', $restaurant->match_dietary_preferences) }}" min="0" max="9" oninput="this.nextElementSibling.textContent = this.value">
                                <span class="range-value">{{ $restaurant->match_dietary_preferences }}</span>
                            </div>
                            @error('match_dietary_preferences')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.restaurants.blade.index') }}" class="btn btn-secondary">Anuluj</a>
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Inicjalizacja wartości dla suwaków
        document.addEventListener('DOMContentLoaded', function() {
            const ranges = document.querySelectorAll('input[type="range"]');
            ranges.forEach(range => {
                range.nextElementSibling.textContent = range.value;
            });
        });
    </script>
</body>
</html>
