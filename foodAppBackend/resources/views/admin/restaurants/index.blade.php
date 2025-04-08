<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administracyjny Restauracji</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel Administracyjny Restauracji</h1>
    </header>

    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Lista Restauracji</h2>
                <a href="{{ route('admin.restaurants.blade.create') }}" class="btn btn-primary">Dodaj Restaurację</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Miasto</th>
                        <th>Kuchnia</th>
                        <th>Ocena</th>
                        <th>Dopasowanie</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->name }}</td>
                            <td>{{ $restaurant->city }}</td>
                            <td>{{ $restaurant->cuisine }}</td>
                            <td>{{ $restaurant->rating }}</td>
                            <td>
                                <div><strong>Ogólne: {{ number_format($restaurant->match_score, 1) }}/5</strong></div>
                                <div>Osoby: {{ $restaurant->match_people_count }}/9</div>
                                <div>Cena: {{ $restaurant->match_price_per_person }}/9</div>
                                <div>Posiłek: {{ $restaurant->match_meal_type }}/9</div>
                                <div>Cel: {{ $restaurant->match_visit_purpose }}/9</div>
                                <div>Dieta: {{ $restaurant->match_dietary_preferences }}/9</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.restaurants.blade.edit', $restaurant->id) }}" class="btn btn-secondary">Edytuj</a>
                                <a href="{{ route('admin.restaurants.answers.edit', $restaurant->id) }}" class="btn btn-secondary">Dopasowania</a>
                                <form action="{{ route('admin.restaurants.blade.destroy', $restaurant->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Czy na pewno chcesz usunąć tę restaurację?')">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
