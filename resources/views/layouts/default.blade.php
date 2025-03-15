<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Test Frellas' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

<body class="relative bg-[#EBEFFF]">
    <x-nav-bar />
        <div class="min-h-screen flex flex-col">
            <div class="flex-grow container mx-auto p-6">
                @yield('content')
            </div>
        </div>
    <x-footer />
</body>
</html>
