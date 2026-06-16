@extends('layouts.app')
@section('title', 'Проекты - TaskUP')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<img src="{{ asset('images/background_img.png') }}" class="bg-img dashboard-bg-img" alt="">

<div class="container dashboard-container">
    <section>
        <div class="projects-heading">
            <h3>Ваши проекты ({{ $projects->count() }}):</h3>
            <button
                type="button"
                class="projects-create-button"
                onclick="document.getElementById('create-project-modal').showModal()"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Создать проект</span>
            </button>
        </div>
        <div class="project-grid">

            @forelse($projects as $project)
                <div class="project-block">
                    <h4>{{ $project->title }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($project->description, 300) ?: 'Нет описания' }}</p>
                    <p class="project-meta">Команда: {{ $project->team->name }} | Задач: {{ $project->tasks->count() }}</p>
                </div>
                <div class="tools-bar">
                    <a class="tool-look" href="{{ route('projects.tasks', $project) }}">
                        <img src="{{ asset('images/look.svg') }}" alt="icon">
                        <p>Просмотреть</p>
                    </a>
                    @if($project->team->owner_id === auth()->id())
                        <a class="tool-edit" href="{{ route('projects.settings', $project) }}">
                            <img src="{{ asset('images/edit.svg') }}" alt="icon">
                            <p>Редактировать</p>
                        </a>
                    @endif
                    @if($project->team->owner_id === auth()->id())
                        <button
                            type="button"
                            class="tool-delete"
                            aria-label="Удалить проект"
                            onclick="document.getElementById('delete-project-{{ $project->id }}').showModal()"
                        >
                            <img src="{{ asset('images/delete.svg') }}" alt="">
                        </button>
                    @endif
                </div>

                @if($project->team->owner_id === auth()->id())
                    <dialog class="project-delete-modal" id="delete-project-{{ $project->id }}">
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="project-delete-form">
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="project-delete-close"
                                aria-label="Закрыть"
                                onclick="document.getElementById('delete-project-{{ $project->id }}').close()"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <div class="project-delete-icon">
                                <i class="fa-regular fa-trash-can"></i>
                            </div>

                            <h2>Вы хотите удалить этот проект?</h2>
                            <p>Проект «{{ $project->title }}» и все связанные данные будут удалены.</p>

                            <div class="project-delete-actions">
                                <button
                                    type="button"
                                    class="project-delete-cancel"
                                    onclick="document.getElementById('delete-project-{{ $project->id }}').close()"
                                >
                                    Отмена
                                </button>
                                <button type="submit" class="project-delete-confirm">Удалить</button>
                            </div>
                        </form>
                    </dialog>
                @endif
            @empty
                <div class="project-block">
                    <h4>Проекты не найдены</h4>
                    <p>Создайте первый проект или попросите добавить вас в команду, к которой он привязан.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

<dialog class="project-create-modal" id="create-project-modal">
    <form class="project-create-modal-form" action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="project-create-modal-header">
            <h2>Создать проект</h2>
            <button
                type="button"
                class="project-create-modal-close"
                aria-label="Закрыть"
                onclick="document.getElementById('create-project-modal').close()"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <label>
            <span>Название проекта</span>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Введите название"
                required
            >
            @error('title')
                <small class="project-create-error">{{ $message }}</small>
            @enderror
        </label>

        <label>
            <span>Команда</span>
            <select name="team_id" required>
                <option value="">Выберите команду</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" @selected((string) old('team_id') === (string) $team->id)>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
            @error('team_id')
                <small class="project-create-error">{{ $message }}</small>
            @enderror
        </label>

        <label>
            <span>Описание проекта</span>
            <textarea name="description" rows="4" placeholder="Опишите проект">{{ old('description') }}</textarea>
            @error('description')
                <small class="project-create-error">{{ $message }}</small>
            @enderror
        </label>

        <div class="project-create-modal-actions">
            <button
                type="button"
                class="project-create-modal-cancel"
                onclick="document.getElementById('create-project-modal').close()"
            >
                Отмена
            </button>
            <button type="submit" class="project-create-modal-submit">Создать</button>
        </div>
    </form>
</dialog>

@if ($errors->hasAny(['title', 'team_id', 'description']))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('create-project-modal')?.showModal();
        });
    </script>
@endif
@endsection

