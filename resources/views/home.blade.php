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
                            <h4 class="feature-title">Легкая адаптация</h4>
                            <p class="feature-text">Легкий порог вхождения и понятный интерфейс</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <img src="{{ asset('images/optimization.svg') }}" alt="" class="feature-icon-img">
                        <div>
                            <h4 class="feature-title">Высокая оптимизация</h4>
                            <p class="feature-text">Быстрая и стабильная работа даже в больших проектах</p>
                        </div>
                    </div>
                </div>
                <a href="#features" class="link-more">Хотите узнать больше?</a>
            </div>

            <div class="hero-content">
                <img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="hero-logo">
                <p>Это сайт для оптимизации командной работы. Он объединяет управление задачами и ведение документации
                    в одном пространстве, помогая команде сохранять фокус и контроль над процессом</p>
                <a class="btn-primary" href="{{ auth()->check() ? route('dashboard') : route('register') }}">Приступить</a>
            </div>
        </div>
    </section>

    <div class="arrow-container">
        <img src="{{ asset('images/arrow.svg') }}" alt="↓" id="arrow">
    </div>

    <section class="features-section" id="features">
        <div class="container">
            <div class="feature-block">
                <h3>Команды</h3>
                <p>TaskUp помогает <b>создавать команды и подключать участников</b> к общей работе. Собирайте людей вокруг проекта, распределяйте задачи и держите командное пространство в одном месте.</p>
                <a class="btn-outline" href="{{ auth()->check() ? route('teams.index') : route('register') }}">Создать команду</a>
            </div>
            <div class="feature-image">
                <img src="{{ asset('images/создание команды.jpg') }}" alt="Создание команды в TaskUp">
            </div>
        </div>

        <div class="container">
            <div class="feature-image">
                <img src="{{ asset('images/Канбан доска.jpg') }}" alt="Kanban-доска проекта в TaskUp">
            </div>
            <div class="feature-block">
                <h3>Kanban-доски</h3>
                <p>TaskUp предоставляет возможность <b>создавать Kanban-доски</b> для ваших проектов. Благодаря им можно легко управлять рабочим процессом, назначать задачи, редактировать приоритеты, комментировать идеи и следить за продуктивностью команды.</p>
                <a class="btn-outline" href="{{ auth()->check() ? route('projects.index') : route('register') }}">Создать Kanban-доску</a>
            </div>
        </div>

        <div class="container">
            <div class="feature-block">
                <h3>Документация</h3>
                <p>Благодаря TaskUp вы можете <b>продуктивно работать с документацией проекта</b>. Создавайте блоки и списки, описывайте правила и технические требования, чтобы вся нужная информация хранилась на одной странице проекта.</p>
                <a class="btn-outline" href="{{ auth()->check() ? route('projects.index') : route('register') }}">Создать документацию</a>
            </div>
            <div class="feature-image">
                <img src="{{ asset('images/Документация.jpg') }}" alt="Документация проекта в TaskUp">
            </div>
        </div>
    </section>
@endsection
