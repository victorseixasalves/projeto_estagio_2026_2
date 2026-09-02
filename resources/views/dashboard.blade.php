<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl leading-tight">
            {{ __('Painel de Sócios') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-[#1E1D24] border border-black/10 dark:border-white/10 rounded-xl overflow-hidden">

                @if ($socios->isEmpty())
                    <p class="text-center text-black/50 dark:text-white/50 py-16 text-sm">
                        {{ __('Nenhum sócio cadastrado ainda.') }}
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-black/10 dark:border-white/10 text-left text-black/50 dark:text-white/50">
                                    @foreach ([
                                    'nome' => 'Nome',
                                    'email' => 'Email',
                                    'tipo' => 'Plano',
                                    'data' => 'Data',
                                    'setor' => 'Setor',
                                    'status' => 'Status',
                                ] as $campo => $rotulo)
                                    <th class="px-5 py-3 font-medium">
                                        <a href="{{ route('dashboard', [
                                        'coluna' => $campo,
                                        'direcao' => ($coluna === $campo && $direcao === 'asc') ? 'desc' : 'asc',
                                        ]) }}"
                                        class="inline-flex items-center gap-1 hover:text-[#16151A] dark:hover:text-white transition-colors">
                                        {{ __($rotulo) }}
                                        @if ($coluna === $campo)
                                        <span class="text-[10px]">{{ $direcao === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/5 dark:divide-white/5">
                                @foreach ($socios as $socio)
                                    <tr class="transition-colors hover:brightness-95 dark:hover:brightness-125
                                        {{ $loop->iteration % 2 === 0
                                            ? 'bg-[#1B7A43]/5 dark:bg-[#1B7A43]/10'
                                            : 'bg-[#6D1B36]/5 dark:bg-[#6D1B36]/10' }}">
                                        <td class="px-5 py-3 font-medium">{{ $socio->nome }}</td>
                                        <td class="px-5 py-3 text-black/60 dark:text-white/60">{{ $socio->email }}</td>
                                        <td class="px-5 py-3">{{ __($socio->tipo) }}</td>
                                        <td class="px-5 py-3 text-black/60 dark:text-white/60">{{ $socio->data->format('d/m/Y') }}</td>
                                        <td class="px-5 py-3">{{ __($socio->setor) }}</td>
                                        <td class="px-5 py-3">
                                            @php
                                                $cores = [
                                                    'pendente' => 'bg-amber-100 text-amber-800 dark:bg-amber-400/10 dark:text-amber-300',
                                                    'confirmado' => 'bg-green-100 text-green-800 dark:bg-green-400/10 dark:text-green-300',
                                                    'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-400/10 dark:text-red-300',
                                                ];
                                            @endphp
                                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $cores[$socio->status] }}">
                                                {{ ucfirst(__($socio->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>