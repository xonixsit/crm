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

    @livewireStyles
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased text-white bg-gradient-to-br from-indigo-700 via-purple-800 to-black dark:from-gray-900 dark:to-black">

    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Header --}}
        @if (isset($header))
            <header class="bg-white/20 dark:bg-gray-800/30 backdrop-blur-lg shadow-md border-b border-white/20 dark:border-gray-700 rounded-xl">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-grow px-4 py-6 sm:px-6 lg:px-8 glassmorphism rounded-xl">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
<livewire:wire-elements-modal />
@livewireScripts
@vite(['resources/js/app.js'])
</body>
</html>