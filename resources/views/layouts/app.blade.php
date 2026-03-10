<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BaltBazaar') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen bg-white">

            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Optional Page Heading -->
            @isset($header)
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500">
                <span>&copy; {{ date('Y') }} BaltBazaar. Visas tiesības aizsargātas.</span>
                <div class="flex gap-6">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-gray-800 transition-colors">Privātuma politika</a>
                    <a href="{{ route('legal.terms') }}" class="hover:text-gray-800 transition-colors">Lietošanas noteikumi</a>
                </div>
            </div>
        </footer>
    </body>
</html>
