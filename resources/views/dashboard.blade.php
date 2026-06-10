@extends('layouts.app')
@section('title', 'Управление - TaskUP')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<div class="container dashboard-container">
    <section class="welc">
        <h2>Добро пожаловать, {{ auth()->user()->name }}!</h2>
        <p>{{ now()->format('d/m/y') }}</p>
    </section>

    <section class="stat">
        <h3>Ваша активность:</h3>
        <div class="stat-grid">

            <div class="stat-block">
                <h4>Ваши проекты:</h4>
                <p class="stat-text">🗂️ 3</p>
            </div>

            <div class="stat-block">
                <h4>Активные задачи:</h4>
                <p class="stat-text">🚀 12</p>
            </div>

            <div class="stat-block">
                <h4>Завершенные задачи:</h4>
                <p class="stat-text">🎯 25</p>
            </div>

            <div class="stat-block">
                <h4>Просроченные задачи:</h4>
                <p class="stat-text">⏳ 2</p>
            </div>

        </div>
    </section>

    <section>
        <h3>Ваши проекты (2):</h3>
        <div class="project-grid">

            <div class="project-block">
                <h4>Разработка игры-рогалика на движке Unity</h4>
                <p>Разрабатываем процедурно генерируемый рогалик с перманентной смертью. Игрок управляет наёмником, спускающимся в бесконечное подземелье. Каждая смерть — полный сброс прогресса, кроме «эссенций» (пассивные улучшения, открываемые за особые достижения).</p>
            </div>
            <div class="tools-bar">
                <div class="tool-look">
                    <img src="{{ asset('images/look.svg') }}" alt="icon">
                    <p>Просмотреть</p>
                </div>
                <div class="tool-edit">
                    <img src="{{ asset('images/edit.svg') }}" alt="icon">
                    <p>Редактировать</p>
                </div>
                <div class="tool-delete">
                    <img src="{{ asset('images/delete.svg') }}" alt="icon">
                </div>
            </div>
        </div>
        <div class="create-project">
            <img alt="icon">
            <p>Создать проект</p>
        </div>
    </section>
</div>
@endsection
