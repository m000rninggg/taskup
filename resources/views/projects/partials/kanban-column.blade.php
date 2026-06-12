<section class="col-kanban">
    @php
        $modalId = 'add-task-' . $status;
    @endphp

    <div class="title-kanban">
        <h3>
            {{ $label }} <span>({{ $tasks->count() }})</span>
            <i class="status-indicator status-{{ $status }}"></i>
        </h3>

        <div class="kanban-column-actions">
            <button type="button" class="icon-btn" aria-label="Добавить задачу" onclick="document.getElementById('{{ $modalId }}').showModal()">
                <i class="fa-solid fa-plus"></i>
            </button>
            <button type="button" class="icon-btn" aria-label="Настройки статуса">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
        </div>
    </div>

    <div class="grid-kanban">
        @forelse($tasks as $task)
            @include('projects.partials.task-card', ['task' => $task])
        @empty
            <div class="empty-kanban">
                Задач пока нет
            </div>
        @endforelse
    </div>

    <button type="button" class="inline-btn add-task-btn" onclick="document.getElementById('{{ $modalId }}').showModal()">
        <i class="fa-solid fa-plus"></i>
        <span>Добавить задачу</span>
    </button>

    <dialog class="task-modal" id="{{ $modalId }}">
        <form class="task-modal-form" action="{{ route('tasks.store', $project) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="{{ $status }}">

            <div class="task-modal-header">
                <h2>Добавить задачу</h2>
                <button type="button" class="task-modal-close" aria-label="Закрыть" onclick="document.getElementById('{{ $modalId }}').close()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <label>
                <span>Название задачи</span>
                <input type="text" name="title" placeholder="Введите название" required>
            </label>

            <label>
                <span>Описание задачи</span>
                <textarea name="description" rows="4" placeholder="Опишите задачу"></textarea>
            </label>

            <label>
                <span>Сроки выполнения</span>
                <input type="date" name="deadline">
            </label>

            <div class="task-modal-actions">
                <button type="button" class="task-modal-cancel" onclick="document.getElementById('{{ $modalId }}').close()">
                    Отмена
                </button>
                <button type="submit" class="task-modal-submit">
                    Добавить
                </button>
            </div>
        </form>
    </dialog>
</section>

