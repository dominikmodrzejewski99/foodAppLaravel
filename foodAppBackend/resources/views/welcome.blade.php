<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 2rem;
                text-align: center;
            }
            h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            p {
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }
            .buttons {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                align-items: center;
            }
            .button {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                text-decoration: none;
                border-radius: 0.375rem;
                transition: all 0.2s;
            }
            .button-primary {
                background-color: #ef4444;
                color: white;
                font-size: 1.1rem;
                padding: 1rem 2rem;
            }
            .button-primary:hover {
                background-color: #dc2626;
            }
            .button-secondary {
                background-color: #4b5563;
                color: white;
            }
            .button-secondary:hover {
                background-color: #374151;
            }
            .auth-links {
                margin-top: 2rem;
                display: flex;
                justify-content: center;
                gap: 1rem;
            }
            .auth-link {
                color: #4b5563;
                text-decoration: none;
                font-weight: 500;
            }
            .auth-link:hover {
                color: #1f2937;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Food App Backend</h1>
            <p>Witaj w panelu administracyjnym aplikacji Food App</p>

            <div class="buttons">
                <a href="/admin/restaurants/blade" class="button button-primary">
                    Przejdź do Panelu Administracyjnego Restauracji
                </a>

                @if (Route::has('login'))
                    <div class="auth-links">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="auth-link">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="auth-link">Logowanie</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="auth-link">Rejestracja</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
