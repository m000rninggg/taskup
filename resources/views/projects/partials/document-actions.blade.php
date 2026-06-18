@php
    $menuId = 'document-menu-' . $document->id;
    $editModalId = 'edit-document-' . $document->id;
@endphp

<div class="document-summary-actions">
    <span class="document-toggle">
        <span class="show-label">Просмотреть</span>
        <span class="hide-label">Свернуть</span>
        <i class="fa-solid fa-arrow-right"></i>
    </span>

    <div class="document-actions">
        <button
            type="button"
            class="document-actions-button"
            aria-label="Действия с темой"
            aria-expanded="false"
            aria-controls="{{ $menuId }}"
            data-document-menu-toggle
        >
            <i class="fa-solid fa-ellipsis"></i>
        </button>

        <div class="document-actions-menu" id="{{ $menuId }}" hidden>
            <button
                type="button"
                class="document-menu-item"
                onclick="event.stopPropagation(); document.getElementById('{{ $editModalId }}').showModal()"
            >
                <i class="fa-regular fa-pen-to-square"></i>
                <span>Редактировать</span>
            </button>

            <form action="{{ route('documents.destroy', $document, absolute: false) }}" method="POST" onclick="event.stopPropagation()">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="document-menu-item document-menu-delete"
                    onclick="return confirm('Удалить эту тему?')"
                >
                    <i class="fa-regular fa-trash-can"></i>
                    <span>Удалить</span>
                </button>
            </form>
        </div>
    </div>
</div>
