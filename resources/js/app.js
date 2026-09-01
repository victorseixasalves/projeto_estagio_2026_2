import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const cores = ['#6D1B36', '#1B7A43'];
    
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

    document.querySelectorAll('.admin-login-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            const cor = cores[Math.floor(Math.random() * cores.length)];
            btn.style.backgroundColor = cor;
            btn.style.borderColor = cor;
            btn.style.color = '#ffffff';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.backgroundColor = '';
            btn.style.borderColor = '';
            btn.style.color = '';
        });
    });

    atualizarIcones();
});