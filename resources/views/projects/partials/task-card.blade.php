<article class="task-card">
    @php
        $creator = $task->creator ?? $task->assignedUser;
    @endphp

    <div class="task-card-header">
        <h4>
            <span class="task-dot task-dot-{{ $task->status }}"></span>
            {{ $task->title }}
        </h4>

        <button type="button" class="task-edit-btn" aria-label="Редактировать задачу">
            <i class="fa-solid fa-ellipsis"></i>
        </button>
    </div>

    <p class="task-description">
        {{ $task->description ?: 'Описание не добавлено' }}
    </p>

    <div class="task-card-footer">
        <span class="task-author-wrap">
            <span class="task-author">
                {{ mb_substr($creator?->name ?? '?', 0, 1) }}
            </span>
            <span class="task-author-name">
                {{ $creator?->name ?? 'Не указан' }}
            </span>
        </span>

        <button type="button" class="comments-btn">
            <i class="fa-regular fa-comment"></i>
            <span>{{ $task->comments->count() }}</span>
        </button>
    </div>

    @if($task->deadline)
        <p class="task-deadline">
            <i class="fa-regular fa-calendar"></i>
            {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('j F') }}
        </p>
    @endif
</article>

