<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskUP')</title>
    @vite(['resources/css/app.css', 'resources/css/home.css'])
    @stack('styles')
</head>
<body>
    @include('layouts.header')

    <main>
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @include('layouts.footer')
</body>
</html>
