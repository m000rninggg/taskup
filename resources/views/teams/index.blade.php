@extends('layouts.app')
@section('title', 'Команды - TaskUP')

@push('styles')
    @vite('resources/css/workspace.css')
    @vite('resources/css/directory.css')
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

                @if ($team->owner_id === auth()->id())
                    <div class="tools-bar team-card-tools">
                        <button
                            type="button"
                            class="tool-edit"
                            onclick="document.getElementById('edit-team-{{ $team->id }}').showModal()"
                        >
                            <img src="{{ asset('images/edit.svg') }}" alt="">
                            <p>Редактировать</p>
                        </button>
                        <button
                            type="button"
                            class="tool-delete"
                            aria-label="Удалить команду"
                            onclick="document.getElementById('delete-team-{{ $team->id }}').showModal()"
                        >
                            <img src="{{ asset('images/delete.svg') }}" alt="">
                        </button>
                    </div>

                    <dialog class="project-create-modal team-edit-modal" id="edit-team-{{ $team->id }}">
                        <div class="project-create-modal-form">
                            <div class="project-create-modal-header">
                                <h2>Редактировать команду</h2>
                                <button
                                    type="button"
                                    class="project-create-modal-close"
                                    aria-label="Закрыть"
                                    onclick="document.getElementById('edit-team-{{ $team->id }}').close()"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <form action="{{ route('teams.update', $team, absolute: false) }}" method="POST" class="team-edit-form">
                                @csrf
                                @method('PATCH')

                                <label>
                                    <span>Название команды</span>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $team->name) }}"
                                        placeholder="Введите название"
                                        required
                                    >
                                    @error('name', 'team_edit_'.$team->id)
                                        <small class="project-create-error">{{ $message }}</small>
                                    @enderror
                                </label>

                                <label>
                                    <span>Добавить участника</span>
                                    <input
                                        type="text"
                                        name="username"
                                        value="{{ old('username') }}"
                                        placeholder="username"
                                    >
                                    <small class="team-create-hint">Введите никнейм пользователя, которого нужно добавить в команду</small>
                                    @error('username', 'team_edit_'.$team->id)
                                        <small class="project-create-error">{{ $message }}</small>
                                    @enderror
                                </label>

                                <div class="project-create-modal-actions">
                                    <button
                                        type="button"
                                        class="project-create-modal-cancel"
                                        onclick="document.getElementById('edit-team-{{ $team->id }}').close()"
                                    >
                                        Отмена
                                    </button>
                                    <button type="submit" class="project-create-modal-submit">Сохранить</button>
                                </div>
                            </form>

                            <section class="team-edit-members">
                                <h3>Участники команды</h3>
                                <div class="team-edit-members-list">
                                    @foreach($team->users as $member)
                                        <div class="team-edit-member">
                                            <span class="team-edit-member-avatar">{{ mb_substr($member->name, 0, 1) }}</span>
                                            <span class="team-edit-member-copy">
                                                <strong>{{ $member->name }}</strong>
                                                <span>{{ $member->username ? '@'.$member->username : 'username не указан' }}</span>
                                            </span>

                                            @if($member->id === $team->owner_id)
                                                <span class="team-owner-label">Владелец</span>
                                            @else
                                                <form action="{{ route('teams.members.destroy', [$team, $member], absolute: false) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="team-member-remove"
                                                        aria-label="Удалить участника из команды"
                                                    >
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    </dialog>

                    <dialog class="project-delete-modal" id="delete-team-{{ $team->id }}">
                        <form action="{{ route('teams.destroy', $team, absolute: false) }}" method="POST" class="project-delete-form">
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="project-delete-close"
                                aria-label="Закрыть"
                                onclick="document.getElementById('delete-team-{{ $team->id }}').close()"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <div class="project-delete-icon">
                                <i class="fa-regular fa-trash-can"></i>
                            </div>

                            <h2>Вы хотите удалить эту команду?</h2>
                            <p>Команда «{{ $team->name }}» и все связанные с ней проекты будут удалены.</p>

                            <div class="project-delete-actions">
                                <button
                                    type="button"
                                    class="project-delete-cancel"
                                    onclick="document.getElementById('delete-team-{{ $team->id }}').close()"
                                >
                                    Отмена
                                </button>
                                <button type="submit" class="project-delete-confirm">Удалить</button>
                            </div>
                        </form>
                    </dialog>
                @else
                    <form action="{{ route('teams.leave', $team, absolute: false) }}" method="POST" class="tools-bar team-card-tools team-leave-tools">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="tool-leave">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <p>Выйти из команды</p>
                        </button>
                    </form>
                @endif
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
    <form class="project-create-modal-form" action="{{ route('teams.store', absolute: false) }}" method="POST">
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
            <span>Имена пользователей</span>
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

@foreach($teams as $team)
    @if($errors->getBag('team_edit_'.$team->id)->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('edit-team-{{ $team->id }}')?.showModal();
            });
        </script>
    @endif
@endforeach
@endsection
