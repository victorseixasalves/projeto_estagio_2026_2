import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const cores = ['#6D1B36', '#1B7A43'];

    const botoes = document.querySelectorAll('.theme-toggle');

    function atualizarIcones() {
        const escuro = document.documentElement.classList.contains('dark');
        document.querySelectorAll('.icon-sun').forEach(icon => icon.classList.toggle('hidden', escuro));
        document.querySelectorAll('.icon-moon').forEach(icon => icon.classList.toggle('hidden', !escuro));
    }

    function corBorda() {
        return document.documentElement.classList.contains('dark') ? '#1E1D24' : '#ffffff';
    }

    function corLegenda() {
        return document.documentElement.classList.contains('dark') ? '#ffffff' : '#16151A';
    }

    const paleta = ['#6D1B36', '#1B7A43', '#B5395F', '#2FA968', '#8C4A61', '#4C9C6E'];
    const graficosCriados = [];

    function criarGraficoPizza(canvasId, dados) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !dados) return;

        const labels = Object.keys(dados);
        const valores = Object.values(dados);
        const total = valores.reduce((soma, v) => soma + v, 0);

        const grafico = new Chart(canvas, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: valores,
                    backgroundColor: paleta,
                    borderColor: corBorda(),
                    borderWidth: 2,
                    hoverOffset: 18,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: corLegenda(),
                            boxWidth: 12,
                            padding: 12,
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const valor = context.parsed;
                                const porcentagem = ((valor / total) * 100).toFixed(1);
                                return `${context.label}: ${valor} (${porcentagem}%)`;
                            },
                        },
                    },
                },
            },
        });

        graficosCriados.push(grafico);
    }

    function atualizarCoresGraficos() {
        graficosCriados.forEach(grafico => {
            grafico.data.datasets[0].borderColor = corBorda();
            grafico.options.plugins.legend.labels.color = corLegenda();
            grafico.update();
        });
    }

    botoes.forEach(btn => {
        btn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const escuro = document.documentElement.classList.contains('dark');
            localStorage.setItem('tema', escuro ? 'escuro' : 'claro');
            atualizarIcones();
            atualizarCoresGraficos();
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

    criarGraficoPizza('grafico-planos', window.dadosPorTipo);
    criarGraficoPizza('grafico-setores', window.dadosPorSetor);

    atualizarIcones();
});