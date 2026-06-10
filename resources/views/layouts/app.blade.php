<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskUP')</title>
    @vite(['resources/css/app.css', 'resources/css/home.css'])
</head>
<body>    
    <main>
        @yield('content')
    </main>

    <footer>
        <h2>TaskUp</h2>
        <nav>
            <a href="/">О продукте</a>
            <a href="/">Возможности</a>
            <a href="/">Помощь</a>
        </nav>
        <p>© 2026 TaskUp | Дипломный проект К. А. Е.</p>
    </footer>
</body>
</html>