<header>
    <div class="container">
        <a href="{{ route('home') }}"><img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="logo"></a>
        <nav>
            @auth
                <a class="nav-link" id="dashboard"href="{{ route('dashboard') }}">Управление</a>
                <a class="nav-link" href="{{ route('projects.index') }}">Проекты</a>
            @endauth
            <a class="nav-link" href="{{ route('home') }}#product">О продукте</a>
            <a class="nav-link" href="{{ route('home') }}#features">Возможности</a>
            <a class="nav-link" href="{{ route('home') }}#help">Помощь</a>
        </nav>
        <div class="auth-buttons">
            @auth
                <a class="btn-register" href="{{ route('profile.edit') }}">Профиль</a>
                <form action="{{ route('logout') }}" method="POST" data-refresh-csrf="true">
                    @csrf
                    <button class="btn-logout" type="submit">Выйти</button>
                </form>
            @else
                <a class="btn-login" href="{{ route('login') }}">Вход</a>
                <a class="btn-register" href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>
    </div>
</header>

