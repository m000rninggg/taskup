@extends('layouts.app')
@section('title', 'Кабинет - TaskUP')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<img src="{{ asset('images/background_img.png') }}" class="bg-img dashboard-bg-img" alt="">

<div class="container dashboard-container">
    <section class="welc">
        <h2>Добро пожаловать, {{ auth()->user()->name }}!</h2>
        <p>{{ now()->format('d/m/y') }}</p>
    </section>

    <section class="dashboard-overview">
        <div class="dashboard-panel">
            <div class="dashboard-panel-header">
                <h3><i class="fa-regular fa-calendar"></i> Ближайшие дедлайны</h3>
                <span>{{ $upcomingDeadlines->count() }}</span>
            </div>

            <div class="dashboard-list">
                @forelse($upcomingDeadlines as $task)
                    <a class="dashboard-list-item" href="{{ route('projects.tasks', $task->project) }}">
                        <span class="dashboard-item-main">
                            <strong>{{ $task->title }}</strong>
                            <small>{{ $task->project->title }}</small>
                        </span>
                        <span class="dashboard-date">
                            {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('j F') }}
                        </span>
                    </a>
                @empty
                    <div class="dashboard-empty">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Ближайших дедлайнов нет</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="dashboard-panel-header">
                <h3><i class="fa-solid fa-list-check"></i> Мои задачи</h3>
                <span>{{ $myTasks->count() }}</span>
            </div>

            <div class="dashboard-list">
                @forelse($myTasks as $task)
                    <a class="dashboard-list-item" href="{{ route('projects.tasks', $task->project) }}">
                        <span class="dashboard-item-main">
                            <strong>{{ $task->title }}</strong>
                            <small>{{ $task->project->title }}</small>
                        </span>
                        <span class="dashboard-status dashboard-status-{{ $task->status }}">
                            {{ $statusLabels[$task->status] ?? $task->status }}
                        </span>
                    </a>
                @empty
                    <div class="dashboard-empty">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Назначенных задач нет</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="dashboard-panel quick-actions-panel">
        <div class="dashboard-panel-header">
            <h3><i class="fa-solid fa-bolt"></i> Быстрые действия</h3>
        </div>

        <div class="quick-actions-grid">
            <a href="{{ route('projects.index') }}" class="quick-action">
                <i class="fa-solid fa-plus"></i>
                <span>Создать проект</span>
            </a>
            <a href="{{ route('teams.index') }}" class="quick-action">
                <i class="fa-solid fa-users"></i>
                <span>Команды</span>
            </a>
            <a href="{{ route('projects.index') }}" class="quick-action">
                <i class="fa-regular fa-folder-open"></i>
                <span>Мои проекты</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="quick-action">
                <i class="fa-regular fa-user"></i>
                <span>Кабинет</span>
            </a>
        </div>
    </section>

</div>
@endsection

