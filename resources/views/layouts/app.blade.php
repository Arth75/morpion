<!DOCTYPE html> 
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>@yield('titre')</title>
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        </head>
        <body>
            <main>
                @yield('contenu')
            </main>
            <footer class="pied">
                <p>BTS SIO SLAM - TP Laravel</p>
            </footer>
        </body>
    </html>
        
            