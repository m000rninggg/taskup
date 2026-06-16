<nav class="project-nav">
    <span class="nav-section-title">Основное</span>
    <a href="{{ route('projects.main', $project) }}" @class(['active' => request()->routeIs('projects.main')])>
        <i class="fa-solid fa-house"></i>
        <span>Главная</span>
    </a>
    <a href="{{ route('projects.tasks', $project) }}" @class(['active' => request()->routeIs('projects.tasks')])>
        <i class="fa-regular fa-square-check"></i>
        <span>Задачи</span>
    </a>
    <a href="{{ route('projects.doc', $project) }}" @class(['active' => request()->routeIs('projects.doc')])>
        <i class="fa-regular fa-file"></i>
        <span>Документация</span>
    </a>

    <span class="nav-section-title">Поддержка</span>
    <a href="{{ route('projects.analytics', $project) }}" @class(['active' => request()->routeIs('projects.analytics')])>
        <i class="fa-regular fa-chart-bar"></i>
        <span>Аналитика</span>
    </a>

    @if($project->team->owner_id === auth()->id())
        <a href="{{ route('projects.settings', $project) }}" @class(['active' => request()->routeIs('projects.settings*')])>
            <i class="fa-solid fa-gear"></i>
            <span>Настройки</span>
        </a>
    @endif
</nav>
