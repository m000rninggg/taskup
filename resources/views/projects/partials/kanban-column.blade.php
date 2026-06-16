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

</section>

