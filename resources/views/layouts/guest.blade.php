<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RedStride</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white antialiased" style="background-color: #070708; color: #ffffff;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: linear-gradient(180deg,#070708 0%,#0b0b0c 100%);">
        <div class="text-center">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-red-600" />
            </a>
            <h1 class="mt-3 text-3xl font-black text-white">RedStride</h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[#0f1112] border border-white/10 shadow-2xl overflow-hidden sm:rounded-lg relative z-10">
            {{ $slot }}
        </div>
    </div>
</body>

</html>