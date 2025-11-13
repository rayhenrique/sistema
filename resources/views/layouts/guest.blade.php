<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'KL PDV')</title>
        @vite(['resources/js/app.js'])
    </head>
    <body class="min-h-screen">
        <header class="px-4 pt-6 md:px-8">
            <div class="glass-card mx-auto flex max-w-6xl flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-500 text-lg font-black text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h10M7 12h10M7 17h6" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-indigo-500">KL PDV</p>
                        <span class="text-sm text-slate-500">Sistema de gestão comercial</span>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 md:hidden">
                    <span class="text-xs uppercase text-slate-400">Menu</span>
                    <button
                        type="button"
                        class="rounded-2xl border border-slate-200 p-2 text-slate-600"
                        aria-expanded="false"
                        aria-controls="guest-nav"
                        data-nav-toggle="#guest-nav"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                </div>

                <nav id="guest-nav" class="hidden flex-col gap-3 text-sm font-semibold text-slate-600 md:flex md:flex-row md:items-center md:gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('home') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 11l9-8 9 8M4 10v10h5v-6h6v6h5V10" />
                            </svg>
                        </span>
                        Início
                    </a>
                    <a href="#recursos" class="flex items-center gap-2 rounded-2xl px-3 py-2 hover:text-slate-900">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h7M4 12h11M4 18h7" />
                            </svg>
                        </span>
                        Recursos
                    </a>
                    <a href="#como-funciona" class="flex items-center gap-2 rounded-2xl px-3 py-2 hover:text-slate-900">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2" />
                            </svg>
                        </span>
                        Como funciona
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 hover:text-slate-900">
                            <span class="inline-flex h-5 w-5 items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15v4h18v-4M7 11l5-5 5 5M12 6v12" />
                                </svg>
                            </span>
                            Painel
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="rounded-2xl px-3 py-2">
                            @csrf
                            <button class="flex items-center gap-2 text-rose-600 hover:text-rose-500">
                                <span class="inline-flex h-5 w-5 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0l-4 4m4-4-4-4m10-2v12a2 2 0 01-2 2h-3" />
                                    </svg>
                                </span>
                                Sair
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-white shadow-md shadow-indigo-200 transition hover:bg-indigo-600">
                            <span class="inline-flex h-5 w-5 items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0-4 4m4-4-4-4m6-2V5a2 2 0 00-2-2H7" />
                                </svg>
                            </span>
                            Entrar
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-12 md:px-8">
            @yield('content')
        </main>

        <footer class="px-4 pb-10 md:px-8">
            <div class="glass-card mx-auto max-w-6xl px-6 py-4 text-sm text-slate-500">
                © {{ now()->format('Y') }} KL PDV · Desenvolvido por Ray Henrique.
            </div>
        </footer>
    </body>
</html>
