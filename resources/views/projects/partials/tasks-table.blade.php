<div class="tasks-table-container">
    <div class="tasks-table">
        <div class="tasks-table-head">
            <span class="table-select-heading" aria-hidden="true"></span>
            <span>Исполнитель</span>
            <span>Задача</span>
            <span>Статус</span>
            <span>Срок выполнения</span>
            <span class="table-actions-heading" aria-hidden="true"></span>
        </div>

        <div class="tasks-table-body">
            @forelse($project->tasks as $task)
                @php
                    $assignee = $task->assignedUser ?? $task->creator;
                    $editModalId = 'edit-task-' . $task->id;
                    $menuId = 'table-task-menu-' . $task->id;
                @endphp

                <article class="tasks-table-row">
                    <span class="table-select" aria-hidden="true"></span>

                    <div class="table-assignee">
                        <span class="table-avatar">
                            {{ mb_substr($assignee?->name ?? '?', 0, 1) }}
                        </span>
                        <span class="table-assignee-copy">
                            <strong>{{ $assignee?->name ?? 'Не назначен' }}</strong>
                            <span>Задача</span>
                        </span>
                    </div>

                    <div class="table-task-copy">
                        <strong>{{ $task->title }}</strong>
                        <span>{{ $task->description ?: 'Описание не добавлено' }}</span>
                    </div>

                    <span class="table-status table-status-{{ $task->status }}">
                        <i class="task-dot task-dot-{{ $task->status }}"></i>
                        {{ $statuses[$task->status] ?? $task->status }}
                    </span>

                    <span class="table-deadline">
                        @if($task->deadline)
                            {{ $task->created_at->format('d/m/y') }} – {{ \Illuminate\Support\Carbon::parse($task->deadline)->format('d/m/y') }}
                        @else
                            Срок не указан
                        @endif
                    </span>

                    <div class="task-actions table-task-actions">
                        <button
                            type="button"
                            class="table-edit-button"
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

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
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
                </article>
            @empty
                <div class="tasks-table-empty">
                    Задач пока нет
                </div>
            @endforelse
        </div>
    </div>

    <button
        type="button"
        class="add-task-btn table-add-task"
        onclick="document.getElementById('add-task-todo').showModal()"
    >
        <i class="fa-solid fa-plus"></i>
        <span>Добавить задачу</span>
    </button>
</div>
