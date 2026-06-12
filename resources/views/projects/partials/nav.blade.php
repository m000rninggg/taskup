<nav class="project-nav">
    <span class="nav-section-title">Основное</span>
    <a href="{{ route('projects.main', $project) }}">
        <i class="fa-solid fa-house"></i>
        <span>Главная</span>
    </a>
    <a href="{{ route('projects.doc', $project) }}">
        <i class="fa-regular fa-file"></i>
        <span>Документация</span>
    </a>
    <a href="{{ route('projects.tasks', $project) }}" class="active">
        <i class="fa-regular fa-square-check"></i>
        <span>Задачи</span>
    </a>

    <span class="nav-section-title">Поддержка</span>
    <a href="{{ route('projects.analitics', $project) }}">
        <i class="fa-regular fa-chart-bar"></i>
        <span>Аналитика</span>
    </a>
    <a href="#">
        <i class="fa-regular fa-comment"></i>
        <span>Обсуждения</span>
    </a>
</nav>

