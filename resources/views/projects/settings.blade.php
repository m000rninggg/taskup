<x-app-layout>
    @push('styles')
        @vite('resources/css/project-settings.css')
        @vite('resources/css/project-shell.css')
    @endpush

    <div class="project-settings-page project-shell">
        @include('projects.partials.sidebar')

        <section class="project-settings-workspace project-shell-workspace">
            @include('projects.partials.topbar', ['icon' => 'fa-solid fa-gear', 'title' => 'Настройки'])

            @if(session('status'))
                <div class="settings-status">{{ session('status') }}</div>
            @endif

            <div class="settings-grid">
                <section class="settings-card">
                    <div class="settings-card-header">
                        <div>
                            <h2>Основная информация</h2>
                            <p>Измените название и описание проекта.</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.settings.update', $project, absolute: false) }}" method="POST" class="settings-form">
                        @csrf
                        @method('PATCH')

                        <label>
                            <span>Название проекта</span>
                            <input type="text" name="title" value="{{ old('title', $project->title) }}" required>
                            @error('title')
                                <small>{{ $message }}</small>
                            @enderror
                        </label>

                        <label>
                            <span>Описание проекта</span>
                            <textarea name="description" rows="6">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <small>{{ $message }}</small>
                            @enderror
                        </label>

                        <div class="settings-form-actions">
                            <button type="submit">Сохранить изменения</button>
                        </div>
                    </form>
                </section>

                <section class="settings-card">
                    <div class="settings-card-header">
                        <div>
                            <h2>Участники проекта</h2>
                            <p>Добавьте пользователя по его никнейму.</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.members.store', $project, absolute: false) }}" method="POST" class="settings-member-form">
                        @csrf
                        <label>
                            <span>Никнейм пользователя</span>
                            <div class="settings-input-action">
                                <input type="text" name="username" value="{{ old('username') }}" placeholder="username" required>
                                <button type="submit">Добавить</button>
                            </div>
                            @error('username')
                                <small>{{ $message }}</small>
                            @enderror
                        </label>
                    </form>

                    <div class="settings-members">
                        @foreach($project->team->users as $member)
                            <div class="settings-member">
                                <span class="settings-member-avatar">{{ mb_substr($member->name, 0, 1) }}</span>
                                <span class="settings-member-copy">
                                    <strong>{{ $member->name }}</strong>
                                    <span>{{ '@'.$member->username }}</span>
                                </span>
                                @if($member->id === $project->team->owner_id)
                                    <span class="settings-owner-label">Владелец</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
    </div>
</x-app-layout>
