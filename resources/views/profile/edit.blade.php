<x-app-layout>
    @push('styles')
        @vite('resources/css/dashboard.css')
    @endpush

    <x-slot name="header">
        <h2 class="breeze-page-title">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="breeze-page">
        <div class="breeze-page-container">
            <section class="stat profile-activity">
                <h3>Ваша активность:</h3>
                <div class="stat-grid">
                    <div class="stat-block">
                        <h4>Ваши проекты:</h4>
                        <p class="stat-text">{{ $projectsCount }}</p>
                    </div>

                    <div class="stat-block">
                        <h4>Активные задачи:</h4>
                        <p class="stat-text">{{ $activeTasksCount }}</p>
                    </div>

                    <div class="stat-block">
                        <h4>Завершённые задачи:</h4>
                        <p class="stat-text">{{ $completedTasksCount }}</p>
                    </div>

                    <div class="stat-block">
                        <h4>Просроченные задачи:</h4>
                        <p class="stat-text">{{ $overdueTasksCount }}</p>
                    </div>
                </div>
            </section>

            <details id="profile-settings" class="profile-settings-card">
                <summary>
                    <span><i class="fa-solid fa-gear"></i> Настройка профиля</span>
                    <span class="profile-settings-toggle">
                        <span class="show-label">Открыть</span>
                        <span class="hide-label">Скрыть</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>

                <div class="profile-settings-body">
                    <div id="profile-information" class="breeze-panel profile-settings-panel">
                        <div class="breeze-form-width">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="breeze-panel profile-settings-panel">
                        <div class="breeze-form-width">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="breeze-panel profile-settings-panel">
                        <div class="breeze-form-width">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </details>
        </div>
    </div>
</x-app-layout>

