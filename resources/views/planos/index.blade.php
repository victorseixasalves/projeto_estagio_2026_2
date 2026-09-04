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
                <form method="POST" action="{{ route('planos.store') }}" class="flex flex-col gap-3">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="nome" placeholder="{{ __('Nome do plano') }}" value="{{ old('nome') }}"
                            class="flex-1 rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">
                        <button type="submit"
                            class="px-5 py-2 rounded-lg bg-[#6D1B36] hover:bg-[#5a1629] text-white text-sm font-medium transition-colors">
                            {{ __('Adicionar') }}
                        </button>
                    </div>
                    @error('nome') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

                    <textarea name="beneficios" rows="3" placeholder="{{ __('Benefícios (um por linha)') }}"
                        class="w-full rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">{{ old('beneficios') }}</textarea>
                    @error('beneficios') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

                    <label class="flex items-center gap-2 text-sm text-black/70 dark:text-white/70">
                        <input type="checkbox" name="destaque" value="1" {{ old('destaque') ? 'checked' : '' }}
                            class="rounded border-black/20 dark:border-white/20 text-[#6D1B36] focus:ring-[#6D1B36]">
                        {{ __('Marcar como plano em destaque (aparece como "Mais popular")') }}
                    </label>
                </form>
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
                                        @if ($plano->destaque)
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#6D1B36]/10 text-[#6D1B36] dark:bg-[#6D1B36]/20 dark:text-[#e0567f]">
                                                {{ __('Destaque') }}
                                            </span>
                                        @endif
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
                                                class="px-3 py-1 rounded-full text-xs font-medium border border-black/15 dark:border-white/15 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                                {{ $plano->ativo ? __('Desativar') : __('Ativar') }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('planos.destroy', $plano) }}"
                                            onsubmit="return confirm('{{ __('Tem certeza que deseja excluir o plano :nome? Essa ação não pode ser desfeita.', ['nome' => $plano->nome]) }}');">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-[#6D1B36] hover:bg-[#5a1629] text-white transition-colors">
                                                {{ __('Excluir') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <form x-show="editando" method="POST" action="{{ route('planos.update', $plano) }}"
                                    class="flex flex-col gap-3">
                                    @csrf
                                    @method('patch')
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <input type="text" name="nome" value="{{ $plano->nome }}"
                                            class="flex-1 rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">
                                        <div class="flex gap-2 shrink-0">
                                            <button type="submit"
                                                class="px-4 py-2 rounded-lg bg-[#1B7A43] hover:bg-[#166437] text-white text-sm font-medium transition-colors">
                                                {{ __('Salvar') }}
                                            </button>
                                            <button type="button" @click="editando = false"
                                                class="px-4 py-2 rounded-lg border border-black/15 dark:border-white/15 text-sm font-medium hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                                {{ __('Cancelar') }}
                                            </button>
                                        </div>
                                    </div>

                                    <textarea name="beneficios" rows="3" placeholder="{{ __('Benefícios (um por linha)') }}"
                                        class="w-full rounded-lg bg-[#F5F3F0] dark:bg-white/5 border border-black/15 dark:border-white/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1B7A43]">{{ $plano->beneficios }}</textarea>

                                    <label class="flex items-center gap-2 text-sm text-black/70 dark:text-white/70">
                                        <input type="checkbox" name="destaque" value="1" {{ $plano->destaque ? 'checked' : '' }}
                                            class="rounded border-black/20 dark:border-white/20 text-[#6D1B36] focus:ring-[#6D1B36]">
                                        {{ __('Marcar como plano em destaque (aparece como "Mais popular")') }}
                                    </label>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>