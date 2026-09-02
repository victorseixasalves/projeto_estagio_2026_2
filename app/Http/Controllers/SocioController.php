<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocioController extends Controller
{
    /**
     * Lista todos os sócios cadastrados, ordenados pela data de início.
     */
    public function index(Request $request): View
    {
        $colunasPermitidas = ['nome', 'email', 'tipo', 'data', 'setor', 'status'];

        $coluna = in_array($request->query('coluna'), $colunasPermitidas)
            ? $request->query('coluna')
            : 'data';

        $direcao = $request->query('direcao') === 'desc' ? 'desc' : 'asc';

        $socios = Socio::orderBy($coluna, $direcao)->get();

        $porTipo = Socio::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        $porSetor = Socio::selectRaw('setor, count(*) as total')
            ->groupBy('setor')
            ->pluck('total', 'setor');

        return view('dashboard', compact('socios', 'coluna', 'direcao', 'porTipo', 'porSetor'));
    }

    /**
     * Mostra a página pública com as informações e o formulário de cadastro.
     */
    public function create(): View
    {
        return view('socios.create');
    }

    /**
     * Recebe o formulário, valida e salva o registro como pendente.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tipo' => ['required', 'in:Tradição Tricolor,Guerreiro do Laranjeiras,Eterno Campeão,FluKids'],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'setor' => ['required', 'in:Norte,Sul,Maracanã Mais,Visitante'],
        ]);

        Socio::create($validated);

        return redirect()
            ->route('socios.create')
            ->with('success', 'Cadastro enviado com sucesso! Em breve entraremos em contato.');
    }
}