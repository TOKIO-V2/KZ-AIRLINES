<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/0/614.png" type="image/x-icon">
        <title>@yield('title', "KZ AIRLINES")</title>
    </head>
    <body>
        <div id="app">
            <x-header />

            <main>
                @yield('content')
            </main>
            
            <x-footer />
        </div>

        <script src="{{ asset('js/script.js')}}"></script>
        
    </body>
</html>