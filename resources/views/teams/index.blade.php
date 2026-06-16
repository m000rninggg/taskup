@extends('layouts.app')
@section('title', 'Команды - TaskUP')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<img src="{{ asset('images/background_img.png') }}" class="bg-img dashboard-bg-img" alt="">

<div class="container dashboard-container">
    <section>
        <div class="projects-heading">
            <h3>Мои команды ({{ $teams->count() }}):</h3>
            <button
                type="button"
                class="projects-create-button"
                onclick="document.getElementById('create-team-modal').showModal()"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Создать команду</span>
            </button>
        </div>

        @if (session('status'))
            <div class="team-status">
                {{ session('status') }}
            </div>
        @endif

        <div class="project-grid">
            @forelse($teams as $team)
                <article class="project-block team-block">
                    <h4>{{ $team->name }}</h4>

                    <p class="team-members">
                        <span>Участники ({{ $team->users->count() }}):</span>
                        {{ $team->users->map(function ($member) {
                            return $member->username
                                ? $member->name.' (@'.$member->username.')'
                                : $member->name;
                        })->join(', ') ?: 'участников пока нет' }}
                    </p>

                    <p class="project-meta">
                        Владелец: {{ $team->owner?->name ?? 'не указан' }}
                        <span class="team-meta-divider">|</span>
                        Проектов: {{ $team->projects_count }}
                    </p>
                </article>

                <div class="team-actions">
                    <div class="tools-bar">
                        <a class="tool-look" href="{{ route('projects.index') }}">
                            <img src="{{ asset('images/look.svg') }}" alt="">
                            <p>Открыть проекты</p>
                        </a>
                    </div>

                    @if ($team->owner_id === auth()->id())
                        <form action="{{ route('teams.members.store', $team) }}" method="POST" class="team-member-form">
                            @csrf
                            <label class="breeze-visually-hidden" for="team-member-{{ $team->id }}">Никнейм пользователя</label>
                            <input
                                id="team-member-{{ $team->id }}"
                                type="text"
                                name="username"
                                placeholder="Никнейм пользователя"
                                required
                            >
                            <button type="submit">
                                <i class="fa-solid fa-plus"></i>
                                <span>Добавить участника</span>
                            </button>
                        </form>

                        @error('username')
                            <p class="team-form-error">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
            @empty
                <div class="project-block">
                    <h4>Команды не найдены</h4>
                    <p>Создайте первую команду, чтобы приглашать участников и работать над общими проектами.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

<dialog class="project-create-modal" id="create-team-modal">
    <form class="project-create-modal-form" action="{{ route('teams.store') }}" method="POST">
        @csrf

        <div class="project-create-modal-header">
            <h2>Создать команду</h2>
            <button
                type="button"
                class="project-create-modal-close"
                aria-label="Закрыть"
                onclick="document.getElementById('create-team-modal').close()"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <label>
            <span>Название команды</span>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Введите название"
                required
            >
            @error('name')
                <small class="project-create-error">{{ $message }}</small>
            @enderror
        </label>

        <label>
            <span>Имя пользователей</span>
            <input
                type="text"
                name="member_usernames"
                value="{{ old('member_usernames') }}"
                placeholder="user_one, user_two, user_three"
            >
            <small class="team-create-hint">Введите логины пользователей через запятую</small>
            @error('member_usernames')
                <small class="project-create-error">{{ $message }}</small>
            @enderror
        </label>

        <div class="project-create-modal-actions">
            <button
                type="button"
                class="project-create-modal-cancel"
                onclick="document.getElementById('create-team-modal').close()"
            >
                Отмена
            </button>
            <button type="submit" class="project-create-modal-submit">Создать</button>
        </div>
    </form>
</dialog>

@if ($errors->hasAny(['name', 'member_usernames']))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('create-team-modal')?.showModal();
        });
    </script>
@endif
@endsection
