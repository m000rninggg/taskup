@php
    $editModalId = 'edit-document-' . $document->id;
@endphp

<dialog class="document-modal" id="{{ $editModalId }}">
    <form class="document-modal-form" action="{{ route('documents.update', $document, absolute: false) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="document-modal-header">
            <h2>Редактировать тему</h2>
            <button
                type="button"
                class="document-modal-close"
                aria-label="Закрыть"
                onclick="document.getElementById('{{ $editModalId }}').close()"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <label>
            <span>Название темы</span>
            <input type="text" name="title" value="{{ $document->title }}" required>
        </label>

        <label>
            <span>Категория</span>
            <select name="category" required>
                <option value="main" @selected($document->category === 'main')>Основное</option>
                <option value="additional" @selected($document->category === 'additional')>Дополнительное</option>
            </select>
        </label>

        <label>
            <span>Описание</span>
            <textarea name="content" rows="5">{{ $document->content }}</textarea>
        </label>

        <div class="document-modal-actions">
            <button
                type="button"
                class="document-modal-cancel"
                onclick="document.getElementById('{{ $editModalId }}').close()"
            >
                Отмена
            </button>
            <button type="submit" class="document-modal-submit">Сохранить</button>
        </div>
    </form>
</dialog>
