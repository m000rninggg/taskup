import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('submit', async (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || form.dataset.refreshCsrf !== 'true') {
        return;
    }

    if (form.dataset.csrfRefreshed === 'true') {
        return;
    }

    event.preventDefault();

    try {
        const response = await fetch('/csrf-token', {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        if (response.ok) {
            const { token } = await response.json();
            const input = form.querySelector('input[name="_token"]');
            const meta = document.querySelector('meta[name="csrf-token"]');

            if (input && token) {
                input.value = token;
            }

            if (meta && token) {
                meta.setAttribute('content', token);
            }
        }
    } finally {
        form.dataset.csrfRefreshed = 'true';
        form.requestSubmit();
    }
});
