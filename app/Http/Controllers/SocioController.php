<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\Plano;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Mail\SocioStatusMail;
use Illuminate\Support\Facades\Mail;

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

        $porTipo = Socio::where('status', 'confirmado')
            ->selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        $porSetor = Socio::where('status', 'confirmado')
            ->selectRaw('setor, count(*) as total')
            ->groupBy('setor')
            ->pluck('total', 'setor');

        return view('dashboard', compact('socios', 'coluna', 'direcao', 'porTipo', 'porSetor'));
    }

    /**
     * Mostra a página pública com as informações e o formulário de cadastro.
     */
    public function create(): View
    {
        $planos = Plano::ativos()->orderBy('nome')->get();
        $setores = Setor::ativos()->orderBy('nome')->get();

        return view('socios.create', compact('planos', 'setores'));
    }

    /**
     * Recebe o formulário, valida e salva o registro como pendente.
     */
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: se esse campo escondido veio preenchido, é bot.
        // Fingimos sucesso (sem salvar nada) para não revelar a proteção.
        if ($request->filled('site_web')) {
            return redirect()
                ->route('socios.create')
                ->with('success', __('Cadastro enviado com sucesso! Em breve entraremos em contato.'));
        }

        $planosAtivos = Plano::ativos()->pluck('nome')->toArray();
        $setoresAtivos = Setor::ativos()->pluck('nome')->toArray();

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:socios,email'],
            'tipo' => ['required', Rule::in($planosAtivos)],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'setor' => ['required', Rule::in($setoresAtivos)],
        ], [
            'email.unique' => __('Este email já possui um cadastro de sócio ativo.'),
        ]);

        Socio::create($validated);

        return redirect()
            ->route('socios.create')
            ->with('success', 'Cadastro enviado com sucesso! Em breve entraremos em contato.');
    }

    /**
     * Confirma o cadastro de um sócio (muda o status para "confirmado")
     * e notifica por email.
     */
    public function confirmar(Socio $socio): RedirectResponse
    {
        $socio->update(['status' => 'confirmado']);

        Mail::to($socio->email)->send(new SocioStatusMail($socio, 'confirmado'));

        return redirect()
            ->route('dashboard')
            ->with('success', 'Cadastro confirmado com sucesso.');
    }

    /**
     * Rejeita e remove definitivamente um cadastro de sócio,
     * notificando por email antes da remoção.
     */
    public function destroy(Socio $socio): RedirectResponse
    {
        Mail::to($socio->email)->send(new SocioStatusMail($socio, 'cancelado'));

        $socio->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Cadastro rejeitado e removido.');
    }
}