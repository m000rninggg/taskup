@extends('layouts.app')
@section('title', 'Задачи - TaskUP')

@push('styles')
    @vite('resources/css/tasks.css')
@endpush

@section('content')

    @php
        $statuses = [
            'todo' => 'Идея',
            'in_progress' => 'В разработке',
            'testing' => 'В тесте',
            'done' => 'Готово',
        ];
    @endphp

    <div class="tasks-page">
        <aside class="tasks-sidebar">
            <div class="sidebar-top">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="sidebar-logo">
                </a>
                <button type="button" class="sidebar-menu-btn" aria-label="Меню">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <button type="button" class="workspace-select">
                <span>{{ \Illuminate\Support\Str::limit($project->title, 18) }}</span>
                <i class="fa-solid fa-sort"></i>
            </button>

            @include('projects.partials.nav')
        </aside>

        <section class="tasks-workspace">
            <div class="tasks-topbar">
                <div class="page-title">
                    <i class="fa-regular fa-square-check"></i>
                    <span>Задачи</span>
                    <i class="fa-solid fa-chevron-down"></i>
                    <i class="fa-solid fa-ellipsis"></i>
                </div>

                <div class="user-panel">
                    <div class="team-avatars">
                        @foreach(auth()->user()->teams->take(5) as $team)
                            <span>{{ mb_substr($team->name, 0, 1) }}</span>
                        @endforeach
                    </div>
                    <button type="button" class="share-btn" aria-label="Поделиться">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                </div>
            </div>

            <div class="view-toolbar">
                <button type="button">Таблица</button>
                <button type="button" class="active">Kanban-доска</button>
                <button type="button" class="filter-btn" aria-label="Фильтр">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>

            <div class="kanban-container">
                <div class="kanban-board">
                    @foreach($statuses as $status => $label)
                        @include('projects.partials.kanban-column', [
                            'project' => $project,
                            'status' => $status,
                            'label' => $label,
                            'tasks' => $project->tasks->where('status', $status),
                        ])
                    @endforeach
                </div>
            </div>
        </section>
    </div>

@endsection

