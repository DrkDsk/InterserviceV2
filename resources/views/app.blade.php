<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#f8fafc" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#020617" media="(prefers-color-scheme: dark)">
        <title inertia>{{ config('app.name', 'interservice') }}</title>
        <script>
            (() => {
                const key = 'interservice-theme';
                const root = document.documentElement;
                const stored = localStorage.getItem(key);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored === 'dark' || stored === 'light' ? stored : (prefersDark ? 'dark' : 'light');
                root.classList.toggle('dark', theme === 'dark');
                root.style.colorScheme = theme;
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
