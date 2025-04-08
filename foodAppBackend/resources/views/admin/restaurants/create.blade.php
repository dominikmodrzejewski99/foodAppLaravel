<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dodaj Restaurację</title>
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
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }
        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 2px solid transparent;
        }
        .tab.active {
            border-bottom-color: #ef4444;
            color: #ef4444;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .question-section {
            margin-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
        }
        .question-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .answers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .answer-item {
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background-color: #f9fafb;
        }
        .answer-text {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .range-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .range-value {
            display: inline-block;
            width: 2rem;
            text-align: center;
            font-weight: 600;
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
                <h2 class="card-title">Dodaj Restaurację</h2>
            </div>

            <div class="tabs">
                <div class="tab active" data-tab="basic-info">Podstawowe informacje</div>
                <div class="tab" data-tab="matching">Dopasowania odpowiedzi</div>
            </div>

            <form action="{{ route('admin.restaurants.blade.store') }}" method="POST">
                @csrf

                <div id="basic-info" class="tab-content active">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="name">Nazwa</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Adres</label>
                                <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="city">Miasto</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="cuisine">Kuchnia</label>
                                <input type="text" id="cuisine" name="cuisine" value="{{ old('cuisine') }}" required>
                                @error('cuisine')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rating">Ocena (0-5)</label>
                                <input type="number" id="rating" name="rating" value="{{ old('rating') }}" min="0" max="5" step="0.1">
                                @error('rating')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="website">Strona internetowa</label>
                                <input type="text" id="website" name="website" value="{{ old('website') }}">
                                @error('website')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ukryte pola dla kompatybilności wstecznej -->
                    <input type="hidden" name="match_people_count" value="5">
                    <input type="hidden" name="match_price_per_person" value="5">
                    <input type="hidden" name="match_meal_type" value="5">
                    <input type="hidden" name="match_visit_purpose" value="5">
                    <input type="hidden" name="match_dietary_preferences" value="5">
                </div>

                <div id="matching" class="tab-content">
                    <p>Ustaw poziom dopasowania restauracji do każdej odpowiedzi (0-10):</p>

                    @foreach($questions as $question)
                        <div class="question-section">
                            <div class="question-title">{{ $question->question_text }}</div>
                            <div class="answers-grid">
                                @foreach($question->answers as $answer)
                                    <div class="answer-item">
                                        <div class="answer-text">{{ $answer->answer_text }}</div>
                                        <div class="range-container">
                                            <input
                                                type="range"
                                                name="answer_matches[{{ $answer->id }}]"
                                                min="0"
                                                max="10"
                                                value="{{ old('answer_matches.' . $answer->id, 5) }}"
                                                oninput="this.nextElementSibling.textContent = this.value"
                                            >
                                            <span class="range-value">5</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.restaurants.blade.index') }}" class="btn btn-secondary">Anuluj</a>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicjalizacja wartości dla suwaków
            const ranges = document.querySelectorAll('input[type="range"]');
            ranges.forEach(range => {
                range.nextElementSibling.textContent = range.value;
            });

            // Obsługa zakładek
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Usuń klasę active ze wszystkich zakładek
                    tabs.forEach(t => t.classList.remove('active'));
                    // Dodaj klasę active do klikniętej zakładki
                    this.classList.add('active');

                    // Ukryj wszystkie zawartości zakładek
                    tabContents.forEach(content => content.classList.remove('active'));
                    // Pokaż zawartość odpowiadającą klikniętej zakładce
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
