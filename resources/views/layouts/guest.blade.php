<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-white antialiased bg-gradient-to-br from-indigo-600 via-purple-700 to-pink-600 dark:from-gray-900 dark:to-black">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        <div class="mb-8">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="CRM Logo" class="h-16 w-auto">
            </a>
        </div>

        <div class="w-full max-w-md bg-white/20 dark:bg-gray-800/30 backdrop-blur-xl border border-white/30 dark:border-gray-700/50 rounded-3xl shadow-2xl px-8 py-10">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
