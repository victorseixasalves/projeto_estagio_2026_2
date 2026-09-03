<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SetorController extends Controller
{
    /**
     * Lista todos os setores, ativos e inativos.
     */
    public function index(): View
    {
        $setores = Setor::orderBy('nome')->get();

        return view('setores.index', compact('setores'));
    }

    /**
     * Cria um novo setor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:setores,nome'],
        ], [
            'nome.unique' => __('Já existe um setor com esse nome.'),
        ]);

        Setor::create($validated);

        return redirect()->route('setores.index')->with('success', __('Setor criado com sucesso.'));
    }

    /**
     * Atualiza o nome de um setor existente.
     */
    public function update(Request $request, Setor $setor): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:setores,nome,'.$setor->id],
        ], [
            'nome.unique' => __('Já existe um setor com esse nome.'),
        ]);

        $setor->update($validated);

        return redirect()->route('setores.index')->with('success', __('Setor atualizado com sucesso.'));
    }

    /**
     * Ativa ou desativa um setor.
     */
    public function alternar(Setor $setor): RedirectResponse
    {
        $setor->update(['ativo' => ! $setor->ativo]);

        return redirect()->route('setores.index')->with('success', __('Status do setor atualizado.'));
    }
}