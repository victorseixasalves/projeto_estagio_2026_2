<nav x-data="{ open: false }" class="bg-white dark:bg-[#1E1D24] border-b border-black/10 dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 rounded-lg bg-[#16151A] dark:bg-white flex items-center justify-center p-1.5">
                        <img src="{{ asset('images/EscudoFLU.png') }}" alt="Fluminense F.C." class="w-full h-full object-contain">
                    </div>
                    <span class="hidden sm:block font-display font-semibold tracking-wide text-sm">FLUMINENSE F.C.</span>
                </a>

                <div class="hidden space-x-6 sm:flex">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 transition-colors
                            {{ request()->routeIs('dashboard')
                                ? 'border-[#6D1B36] text-[#16151A] dark:text-white'
                                : 'border-transparent text-black/50 dark:text-white/50 hover:text-black/80 dark:hover:text-white/80' }}">
                        {{ __('Painel') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-2">
                <a href="{{ route('locale.switch', app()->getLocale() === 'pt' ? 'en' : 'pt') }}"
                    class="w-9 h-9 shrink-0 rounded-full flex items-center justify-center border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 transition-colors text-xs font-semibold">
                    {{ app()->getLocale() === 'pt' ? 'EN' : 'PT' }}
                </a>

                <button
                    type="button"
                    class="theme-toggle w-9 h-9 shrink-0 rounded-full flex items-center justify-center border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 transition-colors"
                    aria-label="{{ __('Alternar tema claro/escuro') }}"
                >
                    <svg class="icon-sun hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4"/>
                        <path stroke-linecap="round" d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
                    </svg>
                    <svg class="icon-moon w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 1020.354 15.354z"/>
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-black/60 dark:text-white/60 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-black/50 dark:text-white/50 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-sm font-medium
                    {{ request()->routeIs('dashboard')
                        ? 'border-[#6D1B36] text-[#16151A] dark:text-white'
                        : 'border-transparent text-black/50 dark:text-white/50' }}">
                {{ __('Painel') }}
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-black/10 dark:border-white/10">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-black/50 dark:text-white/50">{{ Auth::user()->email }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('locale.switch', app()->getLocale() === 'pt' ? 'en' : 'pt') }}"
                        class="w-9 h-9 shrink-0 rounded-full flex items-center justify-center border border-black/10 dark:border-white/10 text-xs font-semibold">
                        {{ app()->getLocale() === 'pt' ? 'EN' : 'PT' }}
                    </a>
                    <button
                        type="button"
                        class="theme-toggle w-9 h-9 shrink-0 rounded-full flex items-center justify-center border border-black/10 dark:border-white/10"
                        aria-label="{{ __('Alternar tema claro/escuro') }}"
                    >
                        <svg class="icon-sun hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="4"/>
                            <path stroke-linecap="round" d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
                        </svg>
                        <svg class="icon-moon w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 1020.354 15.354z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>