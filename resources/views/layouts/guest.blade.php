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
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        style="background: var(--bg); color: var(--text);">
            <div>
                <!-- รอโลโก้ -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img
                        src="{{ asset('images/logo.JPG') }}"
                        alt="Stellar Logo"
                        class="h-20 w-auto" 
                    /> 
                </a>
            </div>

            <div class="animated-border shadow">
                <div class="w-full sm:max-w-2xl mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                <!-- <div class="w-full max-w-md sm:max-w-lg lg:max-w-xl mx-auto"> -->
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
