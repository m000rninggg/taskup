<div class="project-shell-topbar">
    <div class="page-title">
        <i class="{{ $icon }}"></i>
        <span>{{ $title }}</span>
    </div>

    <div class="user-panel">
        <div class="team-avatars" aria-label="Участники команды">
            @foreach($project->team->users->take(5) as $member)
                <span title="{{ $member->name }}">{{ mb_substr($member->name, 0, 1) }}</span>
            @endforeach
        </div>
        <span class="user-panel-divider" aria-hidden="true"></span>
        <span class="user-name">{{ auth()->user()->name }}</span>
        <span class="user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
    </div>
</div>
