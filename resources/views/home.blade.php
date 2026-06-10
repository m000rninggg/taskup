@extends('layouts.app')
@section('title', 'Главная - TaskUP')

@section('content')
<img src="{{ asset('images/background_img.png') }}" class="bg-img">
    <section class="hero-section">
        <div class="container">
            <div class="why-us">
                <h3 class="section-subtitle">ПОЧЕМУ МЫ?</h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <img src="{{ asset('images/notifications.svg') }}" alt="notifications" class="feature-icon-img">
                        <div class="feature-first">
                            <h4 class="feature-title">Оповещения Telegram</h4>
                            <p class="feature-text">Уведомления о дедлайнах в Telegram</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img src="{{ asset('images/group.svg') }}" alt="group" class="feature-icon-img">
                        <div class="feature-second">
                            <h4 class="feature-title">Для больших команд</h4>
                            <p class="feature-text">Возможности для работы в больших командах</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img src="{{ asset('images/analytics.svg') }}" alt="analytics" class="feature-icon-img">
                        <div class="feature-third">
                            <h4 class="feature-title">Аналитика</h4>
                            <p class="feature-text">Графики и метрики продуктивности</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img src="{{ asset('images/steps.svg') }}" alt="steps" class="feature-icon-img">
                        <div class="feature-fourth">
                            <h4 class="feature-title">Легкая адаптация</h4    >
                            <p class="feature-text">Легкий порог вхождения и понятный интерфейс</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="link-more">Хотите узнать больше?</a>
            </div>
        
            <div class="hero-content">
                <img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="hero-logo">
                <p>Это сайт для оптимизации командной работы. Он объединяет управление задачами и ведение документации
                    в одном пространстве, помогая команде сохранять фокус и контроль над процессом<p>
                <a class="btn-primary" href="{{ auth()->check() ? route('dashboard') : route('register') }}">Приступить</a>
            </div>
        </div>
    </section>

    <div class="arrow-container">
        <img src="{{ asset('images/arrow.svg') }}" alt="↓" id="arrow">
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
