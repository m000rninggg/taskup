@php
    $creator = $task->creator ?? $task->assignedUser;
    $editModalId = 'edit-task-' . $task->id;
    $menuId = 'task-menu-' . $task->id;
    $commentsModalId = 'task-comments-' . $task->id;
@endphp

<article
    class="task-card"
    draggable="true"
    data-task-card
    data-task-id="{{ $task->id }}"
    data-status="{{ $task->status }}"
    data-update-status-url="{{ route('tasks.status.update', $task, absolute: false) }}"
    data-comments-modal-id="{{ $commentsModalId }}"
>

    <div class="task-card-header">
        <h4>
            <span class="task-dot task-dot-{{ $task->status }}"></span>
            {{ $task->title }}
        </h4>

        <div class="task-actions">
            <button
                type="submit"
                class="task-edit-btn"
                aria-label="Действия с задачей"
                aria-expanded="false"
                aria-controls="{{ $menuId }}"
                data-task-menu-toggle
            >
                <i class="fa-solid fa-ellipsis"></i>
            </button>

            <div class="task-actions-menu" id="{{ $menuId }}" hidden>
                <button
                    type="button"
                    class="task-menu-item"
                    onclick="document.getElementById('{{ $editModalId }}').showModal()"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                    <span>Редактировать</span>
                </button>

                <form action="{{ route('tasks.destroy', $task, absolute: false) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="task-menu-item task-menu-delete"
                        onclick="return confirm('Удалить эту задачу?')"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Удалить</span>
                    </button>
                </form>
            </div>
        </div>
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

        <button
            type="button"
            class="comments-btn"
            onclick="document.getElementById('{{ $commentsModalId }}').showModal()"
        >
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

@include('projects.partials.task-comments-modal', [
    'task' => $task,
    'creator' => $creator,
    'commentsModalId' => $commentsModalId,
])
