<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edytuj Dopasowania Odpowiedzi - {{ $restaurant->name }}</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        header {
            background-color: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            margin-bottom: 1.5rem;
        }
        .card-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
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
            font-weight: 600;
            min-width: 2rem;
            text-align: center;
        }
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .restaurant-info {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .restaurant-detail {
            flex: 1;
        }
        .restaurant-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .match-score {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ef4444;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel Administracyjny Restauracji</h1>
        <a href="{{ route('admin.restaurants.blade.index') }}" class="btn btn-secondary">Powrót do listy</a>
    </header>

    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edytuj Dopasowania Odpowiedzi</h2>
            </div>

            <div class="restaurant-info">
                <div class="restaurant-detail">
                    <div class="restaurant-name">{{ $restaurant->name }}</div>
                    <div>{{ $restaurant->address }}, {{ $restaurant->city }}</div>
                    <div>Kuchnia: {{ $restaurant->cuisine }}</div>
                </div>
                <div class="restaurant-detail">
                    <div>Ocena: {{ $restaurant->rating }}/5</div>
                    <div>Ogólny poziom dopasowania:</div>
                    <div class="match-score">{{ number_format($restaurant->match_score, 1) }}/5</div>
                </div>
            </div>

            <form action="{{ route('admin.restaurants.answers.update', $restaurant->id) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($questions as $question)
                    <div class="question-section">
                        <div class="question-title">{{ $question->question_text }}</div>
                        <div class="answers-grid">
                            @foreach ($question->answers as $answer)
                                <div class="answer-item">
                                    <div class="answer-text">{{ $answer->answer_text }}</div>
                                    <div class="range-container">
                                        <input 
                                            type="range" 
                                            name="matches[{{ $answer->id }}]" 
                                            min="0" 
                                            max="10" 
                                            value="{{ $currentMatches[$answer->id] ?? 5 }}" 
                                            oninput="this.nextElementSibling.textContent = this.value"
                                        >
                                        <span class="range-value">{{ $currentMatches[$answer->id] ?? 5 }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="form-actions">
                    <a href="{{ route('admin.restaurants.blade.index') }}" class="btn btn-secondary">Anuluj</a>
                    <button type="submit" class="btn btn-primary">Zapisz dopasowania</button>
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
