<x-app-layout>
    @push('styles')
        @vite('resources/css/project.css')
        @vite('resources/css/project-shell.css')
    @endpush

    <div class="project-page project-shell">
        @include('projects.partials.sidebar')

        <section class="project-workspace project-shell-workspace">
            @include('projects.partials.topbar', ['icon' => 'fa-solid fa-house', 'title' => 'Главная'])

            <section class="project-summary">
                <h1>{{ $project->title }}</h1>
                <p class="project-description">
                    {{ $project->description ?: 'Описание проекта пока не добавлено.' }}
                </p>
            </section>

            <div class="project-stats">
                <article class="project-stat-card">
                    <span class="project-stat-label">Команда</span>
                    <strong>{{ $project->team->name }}</strong>
                    <div class="project-members">
                        @foreach($project->team->users as $member)
                            <span class="project-member">
                                <span class="project-member-avatar">
                                    {{ mb_substr($member->name, 0, 1) }}
                                </span>
                                <span>{{ $member->name }}</span>@if(! $loop->last)<span class="project-member-comma">,</span>@endif
                            </span>
                        @endforeach
                    </div>
                </article>

                <article class="project-stat-card">
                    <span class="project-stat-label">Задачи</span>
                    <strong>{{ $project->tasks->count() }}</strong>
                </article>

                <article class="project-stat-card">
                    <span class="project-stat-label">Создан</span>
                    <strong>{{ $project->created_at->format('d.m.Y') }}</strong>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>
