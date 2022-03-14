<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div>
    @include('layouts.navigation')




    <div class="w-full flex flex-col sm:flex-row flex-grow overflow-hidden">
        <div class="sm:w-1/4 md:1/4 w-full flex-shrink flex-grow-0 p-4">
            <div class="sticky top-0 p-4 w-full border border-black">
                <ul class="flex sm:flex-col overflow-hidden content-center justify-between">
                    <!-- nav goes here -->123e
                </ul>
                <ul class="flex sm:flex-col overflow-hidden content-center justify-between">
                    <!-- nav goes here -->123e
                </ul>
                <ul class="flex sm:flex-col overflow-hidden content-center justify-between">
                    <!-- nav goes here -->123e
                </ul>
            </div>
        </div>
        <main role="main" class="w-full h-full flex-grow p-3 overflow-auto">
            <!-- content area -->    {{ $slot ?? '' }}asd

        </main>
    </div>
    <footer class="mt-auto">
        ...
    </footer>
</div>
</body>
</html>
