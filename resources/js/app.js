import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const setTaskView = (container, viewName) => {
    container.querySelectorAll('[data-task-view]').forEach((view) => {
        view.toggleAttribute('hidden', view.dataset.taskView !== viewName);
    });

    container.querySelectorAll('[data-task-view-button]').forEach((button) => {
        const isActive = button.dataset.taskViewButton === viewName;
        button.classList.toggle('active', isActive);
        button.setAttribute('aria-pressed', String(isActive));
    });

    window.localStorage.setItem('task-view', viewName);
};

document.querySelectorAll('.tasks-workspace').forEach((container) => {
    const savedView = window.localStorage.getItem('task-view');
    setTaskView(container, savedView === 'table' ? 'table' : 'kanban');
});

document.addEventListener('click', (event) => {
    if (event.target.matches('dialog.task-comments-modal')) {
        const rect = event.target.getBoundingClientRect();
        const isBackdropClick =
            event.clientX < rect.left ||
            event.clientX > rect.right ||
            event.clientY < rect.top ||
            event.clientY > rect.bottom;

        if (isBackdropClick) {
            event.target.close();
        }

        return;
    }

    const viewButton = event.target.closest('[data-task-view-button]');

    if (viewButton) {
        const container = viewButton.closest('.tasks-workspace');

        if (container) {
            setTaskView(container, viewButton.dataset.taskViewButton);
        }

        return;
    }

    const dialogCloseButton = event.target.closest('[data-dialog-close]');

    if (dialogCloseButton) {
        event.preventDefault();
        event.stopPropagation();
        const dialogId = dialogCloseButton.dataset.dialogClose;
        const dialog = dialogId
            ? document.getElementById(dialogId)
            : dialogCloseButton.closest('dialog');

        dialog?.close();
        return;
    }

    const toggle = event.target.closest(
        '[data-task-menu-toggle], [data-popup-menu-toggle], [data-document-menu-toggle]'
    );

    document.querySelectorAll(
        '[data-task-menu-toggle][aria-expanded="true"], [data-popup-menu-toggle][aria-expanded="true"], [data-document-menu-toggle][aria-expanded="true"]'
    ).forEach((button) => {
        const controlledMenu = document.getElementById(button.getAttribute('aria-controls'));
        const isActiveToggle = button === toggle;
        const isParentOfActiveToggle = toggle && controlledMenu?.contains(toggle);

        if (isActiveToggle || isParentOfActiveToggle) {
            return;
        }

        button.setAttribute('aria-expanded', 'false');
        controlledMenu?.setAttribute('hidden', '');
    });

    if (!toggle) {
        return;
    }

    if (toggle.hasAttribute('data-document-menu-toggle')) {
        event.preventDefault();
    }

    const menu = document.getElementById(toggle.getAttribute('aria-controls'));
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';

    toggle.setAttribute('aria-expanded', String(!isOpen));
    menu?.toggleAttribute('hidden', isOpen);
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll(
        '[data-task-menu-toggle][aria-expanded="true"], [data-popup-menu-toggle][aria-expanded="true"], [data-document-menu-toggle][aria-expanded="true"]'
    ).forEach((button) => {
        button.setAttribute('aria-expanded', 'false');
        document.getElementById(button.getAttribute('aria-controls'))?.setAttribute('hidden', '');
    });
});

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

const taskStatusLabels = {
    todo: 'Идея',
    in_progress: 'В разработке',
    testing: 'В тесте',
    done: 'Готово',
};

const replaceStatusClass = (element, prefix, status) => {
    if (!element) {
        return;
    }

    [...element.classList].forEach((className) => {
        if (className.startsWith(prefix)) {
            element.classList.remove(className);
        }
    });

    element.classList.add(`${prefix}${status}`);
};

const syncTaskStatusUi = (card, status) => {
    card.dataset.status = status;
    replaceStatusClass(card.querySelector('.task-dot'), 'task-dot-', status);

    const commentsModal = document.getElementById(card.dataset.commentsModalId);
    const commentsStatus = commentsModal?.querySelector('.task-comments-status');

    if (commentsStatus) {
        replaceStatusClass(commentsStatus, 'task-status-', status);
        commentsStatus.textContent = taskStatusLabels[status] ?? status;
    }
};

const updateKanbanColumnState = (column) => {
    if (!column) {
        return;
    }

    const cardsCount = column.querySelectorAll('[data-task-card]').length;
    const titleCount = column.closest('.col-kanban')?.querySelector('.title-kanban h3 span');
    let emptyState = column.querySelector('[data-kanban-empty]');

    if (titleCount) {
        titleCount.textContent = `(${cardsCount})`;
    }

    if (cardsCount > 0) {
        emptyState?.remove();
        return;
    }

    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.className = 'empty-kanban';
        emptyState.dataset.kanbanEmpty = '';
        emptyState.textContent = 'Задач пока нет';
        column.append(emptyState);
    }
};

let draggedTaskCard = null;
let draggedSourceColumn = null;

document.addEventListener('dragstart', (event) => {
    const card = event.target.closest('[data-task-card]');

    if (!card || event.target.closest('button, a, input, textarea, select, dialog')) {
        event.preventDefault();
        return;
    }

    draggedTaskCard = card;
    draggedSourceColumn = card.closest('[data-kanban-column]');
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/plain', card.dataset.taskId ?? '');

    window.requestAnimationFrame(() => {
        card.classList.add('is-dragging');
    });
});

document.addEventListener('dragover', (event) => {
    const column = event.target.closest('[data-kanban-column]');

    if (!column || !draggedTaskCard) {
        return;
    }

    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
    column.classList.add('is-drag-over');
});

document.addEventListener('dragleave', (event) => {
    const column = event.target.closest('[data-kanban-column]');

    if (column && !column.contains(event.relatedTarget)) {
        column.classList.remove('is-drag-over');
    }
});

document.addEventListener('drop', async (event) => {
    const targetColumn = event.target.closest('[data-kanban-column]');

    if (!targetColumn || !draggedTaskCard) {
        return;
    }

    event.preventDefault();
    targetColumn.classList.remove('is-drag-over');

    const card = draggedTaskCard;
    const sourceColumn = draggedSourceColumn;
    const previousStatus = card.dataset.status;
    const nextStatus = targetColumn.dataset.status;

    if (!nextStatus || previousStatus === nextStatus) {
        return;
    }

    targetColumn.append(card);
    syncTaskStatusUi(card, nextStatus);
    updateKanbanColumnState(sourceColumn);
    updateKanbanColumnState(targetColumn);

    try {
        const response = await fetch(card.dataset.updateStatusUrl, {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify({ status: nextStatus }),
        });

        if (!response.ok) {
            throw new Error('Task status update failed');
        }
    } catch (error) {
        sourceColumn?.append(card);
        syncTaskStatusUi(card, previousStatus);
        updateKanbanColumnState(sourceColumn);
        updateKanbanColumnState(targetColumn);
    }
});

document.addEventListener('dragend', () => {
    draggedTaskCard?.classList.remove('is-dragging');
    document.querySelectorAll('[data-kanban-column].is-drag-over').forEach((column) => {
        column.classList.remove('is-drag-over');
    });
    draggedTaskCard = null;
    draggedSourceColumn = null;
});

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (form instanceof HTMLFormElement && form.hasAttribute('data-prevent-double-submit')) {
        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        form.dataset.submitting = 'true';
        form.querySelectorAll('button[type="submit"]').forEach((button) => {
            button.disabled = true;
        });
    }
});
