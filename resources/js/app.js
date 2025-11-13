import './bootstrap';
import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const setupToggle = (trigger) => {
        const targetSelector = trigger.getAttribute('data-nav-toggle');
        const target = document.querySelector(targetSelector);

        if (!target) {
            return;
        }

        trigger.addEventListener('click', () => {
            const isHidden = target.classList.toggle('hidden');
            trigger.setAttribute('aria-expanded', String(!isHidden));
        });
    };

    document.querySelectorAll('[data-nav-toggle]').forEach(setupToggle);
});
