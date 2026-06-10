<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TaskUP')</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/css/login.css', 'resources/js/app.js'])
</head>
<body class="auth-body">
    <div class="auth-wrapper">
        {{-- Левая часть с информацией --}}
        <div class="auth-info">
            <h2>Task<span>Up</span></h2>
            <p>Единое пространство для управления проектами, задачами и документацией вашей команды</p>
            <div class="auth-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon">✓</div>
                    <span>Управление задачами и статусами</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon">📋</div>
                    <span>Командная документация</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon">💬</div>
                    <span>Комментарии к задачам</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon">📊</div>
                    <span>Канбан-доски</span>
                </div>
            </div>
        </div>

        {{-- Правая часть с формой --}}
        <div class="auth-card">
            <div class="auth-logo">
                Task<span>Up</span>
            </div>
            <div class="auth-subtitle">Войдите в свой аккаунт</div>
            
            {{ $slot }}
        </div>
    </div>
</body>
</html>