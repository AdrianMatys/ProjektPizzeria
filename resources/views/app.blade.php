<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <a href="{{ route('set-locale', ['locale' => 'en']) }}">English</a>
    <a href="{{ route('set-locale', ['locale' => 'pl']) }}">Polski</a>
    <br>Test języku <b>do usunięcia</b>: {{__('pagination.next')}}
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
