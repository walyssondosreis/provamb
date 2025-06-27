<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prova MB')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    </head>
<body>
    <header>
        <nav class="navbar">
            <a href="/" class="navbar-brand">Meu Logo</a>
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/contato">Contato</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Walysson dos Reis. Todos os direitos reservados.</p>
    </footer>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>
