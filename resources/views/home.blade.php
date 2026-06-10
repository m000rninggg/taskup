@extends('layouts.app')
@section('title', 'Главная - TaskUP')

@section('content')
    <header>
        <div class="container">
            <h2 id="logo">TaskUp</h2>
            <nav>
                <a class="nav-link" href="#product">О продукте</a>
                <a class="nav-link" href="#features">Возможности</a>
                <a class="nav-link" href="#help">Помощь</a>
            </nav>
            <div class="auth-buttons">
                <a class="btn-login" href="{{ route('login') }}">Вход</a>
                <a class="btn-register" href="{{ route('register') }}">Регистрация</a>
            </div>
        </div>
    </header>

    <section class="hero-section">
        <div class="container">
            <div class="why-us">
                <h3 class="section-subtitle">ПОЧЕМУ МЫ?</h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <img>
                        <div class="feature-first">
                            <h4>Оповещения Telegram</h3>
                            <p>Уведомления о дедлайнах в Telegram</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img>
                        <div class="feature-second">
                            <h4>Для больших команд</h3>
                            <p>Возможности для работы в больших командах</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img>
                        <div class="feature-third">
                            <h4>Аналитика</h3>
                            <p>Графики и метрики продуктивности</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img>
                        <div class="feature-fourth">
                            <h4>Легкая адаптация</h3>
                            <p>Легкий порог вхождения и понятный интерфейс</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="link-more">Хотите узнать больше?</a>
            </div>
        
            <div class="hero-content">
                <h1 class="hero-title">TaskUp</h1>
                <p>Это сайт для оптимизации командной работы. Он объединяет управление задачами и ведение документации
                    в одном пространстве, помогая команде сохранять фокус и контроль над процессом<p>
                <button class="btn-primary">Приступить</button>
            </div>
        </div>
    </section>

    <div class="arrow-container">
        <img src="#" alt="↓">
    </div>

    <section class="features-section">

        <div class="container">
            <div class="feature-block">
                <h3>Kanban-доски</h3>
                <p>TaskUp предоставляет возможность <b>создавать Kanban-доски</b> для ваших
                проектов. Благодаря им можно легко управлять рабочим процессом и оптимизировать его. Назначайте задачи,
                редактируйте приоритеты, комментируйте идеи, следите за продуктивностью команды.</p>
                <button class="btn-outline">Создать Kanban-доску</button>
            </div>
            <div class="feature-image">
                <img src="#" alt="Kanban-доски">
            </div>
        </div>

        <div class="container">
            <div class="feature-image">
                <img src="#" alt="Документация">
            </div>
            <div class="feature-block">
                <h3>Документация</h3>
                <p>Благодаря TaskUp вы можете <b>продуктивно работать с документацией проекта</b>.
                Создание блоков и списков, описание правил и технических требований. Вся нужная информация
                хранится на одной странице в проектом.
                </p>
                <button class="btn-outline">Создать документацию</button>
            </div>
        </div>
        
        <div class="container">
            <div class="feature-block">
                <h3>Оповещения в Telegram</h3>
                <p>Мы есть в Telegram! <b>Благодаря нашему боту</b> вы не пропустите дедлайны
                и будете оповещены о ближайших задачах или назначениях новых.
                </p>
                <button class="btn-outline">Подключить бота</button>
            </div>
            <div class="feature-image">
                <img src="#" alt="Наш Telegram-бот">
            </div>
        </div>
    </section>
@endsection