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

    <style>
        .login-image {
            background-image: url('backend/media/budget-tracker-bg.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex">
        <div class="flex-1 hidden lg:block">
            <img src="backend/media/budget-tracker-bg.jpg" alt="" class="w-full min-h-screen">
            {{-- <div class="flex items-center justify-center min-h-screen">
                <div class="text-center p-8 text-white"> 
                    <h1 class="text-6xl font-black mb-4">{{ env('APP_NAME') }}</h1>
                    <p class="text-xl">Track your income and expenses effortlessly</p>
                 </div>
            </div>  --}}
        </div>
        <div class="flex-1 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                    {{ env('APP_NAME') }}
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

</body>

</html>
