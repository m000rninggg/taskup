<aside class="project-shell-sidebar">
    <div class="sidebar-top">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="TaskUp" class="sidebar-logo">
        </a>
        <div class="sidebar-menu">
            <button
                type="button"
                class="sidebar-menu-btn"
                aria-label="Открыть меню"
                aria-expanded="false"
                aria-controls="sidebar-navigation-menu"
                data-popup-menu-toggle
            >
                <i class="fa-solid fa-bars"></i>
            </button>

            <nav class="sidebar-popup-menu" id="sidebar-navigation-menu" hidden>
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Главная</span>
                </a>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-regular fa-user"></i>
                    <span>Кабинет</span>
                </a>
                <a href="{{ route('home') }}#help">
                    <i class="fa-regular fa-circle-question"></i>
                    <span>Поддержка</span>
                </a>
            </nav>
        </div>
    </div>

    <div class="workspace-switcher">
        <button
            type="button"
            class="workspace-select"
            aria-expanded="false"
            aria-controls="workspace-projects-menu"
            data-popup-menu-toggle
        >
            <span title="{{ $project->title }}">{{ $project->title }}</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>

        <nav class="workspace-projects-menu sidebar-popup-menu" id="workspace-projects-menu" hidden>
            @foreach($workspaceProjects as $workspaceProject)
                <a
                    href="{{ route('projects.main', $workspaceProject) }}"
                    @class(['active' => $workspaceProject->is($project)])
                    @if($workspaceProject->is($project)) aria-current="page" @endif
                >
                    <i class="fa-regular fa-folder"></i>
                    <span title="{{ $workspaceProject->title }}">{{ $workspaceProject->title }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    @include('projects.partials.nav')
</aside>
