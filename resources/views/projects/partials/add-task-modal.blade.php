<dialog class="task-modal" id="add-task-{{ $status }}">
    <form class="task-modal-form" action="{{ route('tasks.store', $project) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="{{ $status }}">

        <div class="task-modal-header">
            <h2>Добавить задачу</h2>
            <button
                type="button"
                class="task-modal-close"
                aria-label="Закрыть"
                onclick="document.getElementById('add-task-{{ $status }}').close()"
            >
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
            <button
                type="button"
                class="task-modal-cancel"
                onclick="document.getElementById('add-task-{{ $status }}').close()"
            >
                Отмена
            </button>
            <button type="submit" class="task-modal-submit">Добавить</button>
        </div>
    </form>
</dialog>
