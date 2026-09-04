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
            'beneficios' => ['nullable', 'string'],
            'destaque' => ['nullable', 'boolean'],
        ], [
            'nome.unique' => __('Já existe um plano com esse nome.'),
        ]);

        $validated['destaque'] = $request->boolean('destaque');

        if ($validated['destaque']) {
            Plano::where('destaque', true)->update(['destaque' => false]);
        }

        Plano::create($validated);

        return redirect()->route('planos.index')->with('success', __('Plano criado com sucesso.'));
    }

    /**
     * Atualiza um plano existente (nome, benefícios e destaque).
     */
    public function update(Request $request, Plano $plano): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:planos,nome,'.$plano->id],
            'beneficios' => ['nullable', 'string'],
            'destaque' => ['nullable', 'boolean'],
        ], [
            'nome.unique' => __('Já existe um plano com esse nome.'),
        ]);

        $validated['destaque'] = $request->boolean('destaque');

        if ($validated['destaque']) {
            Plano::where('destaque', true)->where('id', '!=', $plano->id)->update(['destaque' => false]);
        }

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

    /**
     * Exclui definitivamente um plano.
     */
    public function destroy(Plano $plano): RedirectResponse
    {
        $plano->delete();

        return redirect()->route('planos.index')->with('success', __('Plano excluído com sucesso.'));
    }
}