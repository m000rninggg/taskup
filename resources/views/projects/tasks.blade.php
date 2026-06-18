@extends('layouts.app')
@section('title', 'Задачи - TaskUP')

@push('styles')
    @vite('resources/css/tasks.css')
    @vite('resources/css/task-comments.css')
    @vite('resources/css/task-modals.css')
    @vite('resources/css/project-shell.css')
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

    <div class="tasks-page project-shell">
        @include('projects.partials.sidebar')

        <section class="tasks-workspace project-shell-workspace">
            @include('projects.partials.topbar', ['icon' => 'fa-regular fa-square-check', 'title' => 'Задачи'])

            <div class="view-toolbar">
                <button
                    type="button"
                    data-task-view-button="table"
                    aria-pressed="false"
                >
                    Таблица
                </button>
                <button
                    type="button"
                    class="active"
                    data-task-view-button="kanban"
                    aria-pressed="true"
                >
                    Kanban-доска
                </button>
                <button type="button" class="filter-btn" aria-label="Фильтр">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>

            <div class="task-view" data-task-view="table" hidden>
                @include('projects.partials.tasks-table', [
                    'project' => $project,
                    'statuses' => $statuses,
                ])
            </div>

            <div class="task-view kanban-container" data-task-view="kanban">
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

            @foreach($statuses as $status => $label)
                @include('projects.partials.add-task-modal', [
                    'project' => $project,
                    'status' => $status,
                ])
            @endforeach

            @foreach($project->tasks as $task)
                @include('projects.partials.edit-task-modal', ['task' => $task])
            @endforeach
        </section>
    </div>

@endsection

