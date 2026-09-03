<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanoController extends Controller
{
    /**
     * Lista todos os planos, ativos e inativos.
     */
    public function index(): View
    {
        $planos = Plano::orderBy('nome')->get();

        return view('planos.index', compact('planos'));
    }

    /**
     * Cria um novo plano.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:planos,nome'],
        ], [
            'nome.unique' => __('Já existe um plano com esse nome.'),
        ]);

        Plano::create($validated);

        return redirect()->route('planos.index')->with('success', __('Plano criado com sucesso.'));
    }

    /**
     * Atualiza o nome de um plano existente.
     */
    public function update(Request $request, Plano $plano): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:planos,nome,'.$plano->id],
        ], [
            'nome.unique' => __('Já existe um plano com esse nome.'),
        ]);

        $plano->update($validated);

        return redirect()->route('planos.index')->with('success', __('Plano atualizado com sucesso.'));
    }

    /**
     * Ativa ou desativa um plano.
     */
    public function alternar(Plano $plano): RedirectResponse
    {
        $plano->update(['ativo' => ! $plano->ativo]);

        return redirect()->route('planos.index')->with('success', __('Status do plano atualizado.'));
    }
}