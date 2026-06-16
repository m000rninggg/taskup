<header>
    <div class="container">
        <a href="{{ route('home') }}"><img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="logo"></a>
        <button
            type="button"
            class="header-menu-toggle"
            aria-label="Открыть навигацию"
            aria-expanded="false"
            aria-controls="header-navigation"
            data-popup-menu-toggle
        >
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav id="header-navigation" hidden>
            @auth
                <a class="nav-link" href="{{ route('profile.edit') }}">Кабинет</a>
                <div class="header-cabinet">
                    <button
                        type="button"
                        class="nav-link header-cabinet-toggle"
                        aria-expanded="false"
                        aria-controls="header-projects-menu"
                        data-popup-menu-toggle
                    >
                        <span>Проекты</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div class="header-cabinet-menu" id="header-projects-menu" hidden>
                        <a href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Управление</span>
                        </a>
                        <a href="{{ route('projects.index') }}">
                            <i class="fa-regular fa-folder-open"></i>
                            <span>Мои проекты</span>
                        </a>
                        <a href="{{ route('teams.index') }}">
                            <i class="fa-solid fa-users"></i>
                            <span>Мои команды</span>
                        </a>
                    </div>
                </div>
            @endauth
            <a class="nav-link" href="{{ route('home') }}#product">О продукте</a>
            <a class="nav-link" href="{{ route('home') }}#features">Возможности</a>
            <a class="nav-link" href="{{ route('home') }}#help">Помощь</a>
            @auth
                <form class="header-nav-logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout" type="submit">Выйти</button>
                </form>
            @endauth
        </nav>
        <div class="auth-buttons">
            @guest
                <a class="btn-login" href="{{ route('login') }}">Вход</a>
                <a class="btn-register" href="{{ route('register') }}">Регистрация</a>
            @endguest
        </div>
    </div>
</header>

