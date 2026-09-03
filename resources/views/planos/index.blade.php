<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl leading-tight">
            {{ __('Planos de Sócio') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#1B7A43]/10 border border-[#1B7A43]/30 text-[#1B7A43] dark:text-green-300 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulário de novo plano -->
            <div class="bg-white dark:bg-[#1E1D24] border border-black/10 dark:border-white/10 rounded-xl p-6">
                <h3 class="font-display font-medium text-base mb-4">{{ __('Adicionar novo plano') }}</h3>
                <form method="POST" action="{{ route('planos.store') }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="nome" placeholder="{{ __('Nome do plano') }}" value="{{ old('nome') }}"
                        class="flex-1 rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#6D1B36] hover:bg-[#5a1629] text-white text-sm font-medium transition-colors">
                        {{ __('Adicionar') }}
                    </button>
                </form>
                @error('nome') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Lista de planos -->
            <div class="bg-white dark:bg-[#1E1D24] border border-black/10 dark:border-white/10 rounded-xl overflow-hidden">
                @if ($planos->isEmpty())
                    <p class="text-center text-black/50 dark:text-white/50 py-10 text-sm">
                        {{ __('Nenhum plano cadastrado ainda.') }}
                    </p>
                @else
                    <ul class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach ($planos as $plano)
                            <li class="p-4 sm:p-5" x-data="{ editando: false }">
                                <div class="flex items-center justify-between gap-4" x-show="!editando">
                                    <div class="flex items-center gap-3">
                                        <span class="font-medium">{{ $plano->nome }}</span>
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $plano->ativo
                                                ? 'bg-green-100 text-green-800 dark:bg-green-400/10 dark:text-green-300'
                                                : 'bg-black/10 text-black/50 dark:bg-white/10 dark:text-white/50' }}">
                                            {{ $plano->ativo ? __('Ativo') : __('Inativo') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <button type="button" @click="editando = true"
                                            class="px-3 py-1 rounded-full text-xs font-medium border border-black/15 dark:border-white/15 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                            {{ __('Editar') }}
                                        </button>

                                        <form method="POST" action="{{ route('planos.alternar', $plano) }}">
                                            @csrf
                                            @method('patch')
                                            <button type="submit"
                                                class="px-3 py-1 rounded-full text-xs font-medium transition-colors
                                                    {{ $plano->ativo
                                                        ? 'bg-[#6D1B36] hover:bg-[#5a1629] text-white'
                                                        : 'bg-[#1B7A43] hover:bg-[#166437] text-white' }}">
                                                {{ $plano->ativo ? __('Desativar') : __('Ativar') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <form x-show="editando" method="POST" action="{{ route('planos.update', $plano) }}"
                                    class="flex flex-col sm:flex-row gap-3">
                                    @csrf
                                    @method('patch')
                                    <input type="text" name="nome" value="{{ $plano->nome }}"
                                        class="flex-1 rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-[#1B7A43] hover:bg-[#166437] text-white text-sm font-medium transition-colors">
                                            {{ __('Salvar') }}
                                        </button>
                                        <button type="button" @click="editando = false"
                                            class="px-4 py-2 rounded-lg border border-black/15 dark:border-white/15 text-sm font-medium hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                            {{ __('Cancelar') }}
                                        </button>
                                    </div>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>