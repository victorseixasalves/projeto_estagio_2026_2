import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const botoes = document.querySelectorAll('.theme-toggle');
    if (botoes.length === 0) return;

    function atualizarIcones() {
        const escuro = document.documentElement.classList.contains('dark');
        document.querySelectorAll('.icon-sun').forEach(icon => icon.classList.toggle('hidden', escuro));
        document.querySelectorAll('.icon-moon').forEach(icon => icon.classList.toggle('hidden', !escuro));
    }

    botoes.forEach(btn => {
        btn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const escuro = document.documentElement.classList.contains('dark');
            localStorage.setItem('tema', escuro ? 'escuro' : 'claro');
            atualizarIcones();
        });
    });

    atualizarIcones();
});