import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('theme-toggle');
    if (!btn) return;

    const iconSun = document.getElementById('icon-sun');
    const iconMoon = document.getElementById('icon-moon');

    function atualizarIcone() {
        const escuro = document.documentElement.classList.contains('dark');
        iconSun.classList.toggle('hidden', escuro);
        iconMoon.classList.toggle('hidden', !escuro);
    }

    btn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        const escuro = document.documentElement.classList.contains('dark');
        localStorage.setItem('tema', escuro ? 'escuro' : 'claro');
        atualizarIcone();
    });

    atualizarIcone();
});