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
        dialogCloseButton.closest('dialog')?.close();
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
