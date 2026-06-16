@php
    $editModalId = 'edit-task-' . $task->id;
@endphp

<dialog class="task-modal" id="{{ $editModalId }}">
    <form class="task-modal-form" action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="task-modal-header">
            <h2>Редактировать задачу</h2>
            <button
                type="button"
                class="task-modal-close"
                aria-label="Закрыть"
                onclick="document.getElementById('{{ $editModalId }}').close()"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <label>
            <span>Название задачи</span>
            <input type="text" name="title" value="{{ $task->title }}" required>
        </label>

        <label>
            <span>Описание задачи</span>
            <textarea name="description" rows="4">{{ $task->description }}</textarea>
        </label>

        <label>
            <span>Статус</span>
            <select name="status">
                <option value="todo" @selected($task->status === 'todo')>Идея</option>
                <option value="in_progress" @selected($task->status === 'in_progress')>В разработке</option>
                <option value="testing" @selected($task->status === 'testing')>В тесте</option>
                <option value="done" @selected($task->status === 'done')>Готово</option>
            </select>
        </label>

        <label>
            <span>Сроки выполнения</span>
            <input
                type="date"
                name="deadline"
                value="{{ $task->deadline ? \Illuminate\Support\Carbon::parse($task->deadline)->format('Y-m-d') : '' }}"
            >
        </label>

        <div class="task-modal-actions">
            <button
                type="button"
                class="task-modal-cancel"
                onclick="document.getElementById('{{ $editModalId }}').close()"
            >
                Отмена
            </button>
            <button type="submit" class="task-modal-submit">Сохранить</button>
        </div>
    </form>
</dialog>
