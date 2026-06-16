<x-app-layout>
    @push('styles')
        @vite('resources/css/project.css')
        @vite('resources/css/project-shell.css')
    @endpush

    <div class="project-page project-shell">
        @include('projects.partials.sidebar')

        <section class="project-workspace project-shell-workspace">
            @include('projects.partials.topbar', ['icon' => 'fa-regular fa-chart-bar', 'title' => 'Аналитика'])

            <section class="project-summary">
                <h1>Аналитика проекта</h1>
                <p class="project-description">{{ $project->title }}</p>
            </section>

            @php
                $tasksCount = $project->tasks->count();
                $doneCount = $project->tasks->where('status', 'done')->count();
                $progress = $tasksCount > 0 ? round(($doneCount / $tasksCount) * 100) : 0;
                $statusLabels = [
                    'todo' => 'Идея',
                    'in_progress' => 'В разработке',
                    'testing' => 'В тесте',
                    'done' => 'Готово',
                ];
            @endphp

            <section class="project-progress-panel">
                <div class="project-progress-header">
                    <div>
                        <span class="project-stat-label">Прогресс по проекту</span>
                        <strong>{{ $progress }}%</strong>
                    </div>
                    <p>{{ $doneCount }} из {{ $tasksCount }} задач выполнено</p>
                </div>

                <div class="project-progress-track" aria-hidden="true">
                    <span style="width: {{ $progress }}%"></span>
                </div>

                <div class="project-progress-statuses">
                    @foreach($statusLabels as $status => $label)
                        <span class="project-progress-status project-progress-status-{{ $status }}">
                            <i></i>
                            {{ $label }}: {{ $project->tasks->where('status', $status)->count() }}
                        </span>
                    @endforeach
                </div>
            </section>

            <div class="project-stats">
                <article class="project-stat-card">
                    <span class="project-stat-label">Всего задач</span>
                    <strong>{{ $project->tasks->count() }}</strong>
                </article>

                <article class="project-stat-card">
                    <span class="project-stat-label">В работе</span>
                    <strong>{{ $project->tasks->where('status', 'in_progress')->count() }}</strong>
                </article>

                <article class="project-stat-card">
                    <span class="project-stat-label">Завершено</span>
                    <strong>{{ $project->tasks->where('status', 'done')->count() }}</strong>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>
