<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'KL PDV')</title>
        @vite(['resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <header class="px-4 pt-6 md:px-8">
            <div class="glass-card relative z-40 mx-auto flex max-w-7xl flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-500 text-lg font-black text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 7h12M6 12h8M6 17h5" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-indigo-500">KL PDV</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 md:hidden">
                    <span class="text-xs uppercase text-slate-400">Menu</span>
                    <button
                        type="button"
                        class="rounded-2xl border border-slate-200 p-2 text-slate-600"
                        aria-expanded="false"
                        aria-controls="app-nav"
                        data-nav-toggle="#app-nav"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                </div>

                <nav
                    id="app-nav"
                    class="hidden flex-col gap-3 text-sm font-semibold text-slate-600 md:flex md:flex-row md:items-center md:gap-6"
                >
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M5 6h14M7 14h10M9 18h6" />
                            </svg>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('orders.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 7h14M5 12h14M5 17h8" />
                            </svg>
                        </span>
                        Pedidos
                    </a>
                    <a href="{{ route('customers.index') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('customers.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                            </svg>
                        </span>
                        Clientes
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('products.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                        </span>
                        Produtos
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('suppliers.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </span>
                        Fornecedores
                    </a>
                    <a href="{{ route('payments.index') }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 {{ request()->routeIs('payments.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">
                        <span class="inline-flex h-5 w-5 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.645 1M12 6v12" />
                            </svg>
                        </span>
                        Contas a Receber
                    </a>

                    <details class="relative z-30 rounded-3xl border border-slate-200 px-3 py-2 text-slate-700 focus-within:ring-2 focus-within:ring-indigo-100 md:border-none md:px-0 md:py-0">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-2xl px-2 py-1 text-sm font-semibold text-slate-700 hover:text-indigo-600">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                                </svg>
                            </span>
                        </summary>
                        <div class="absolute right-0 mt-2 w-48 rounded-2xl border border-slate-200 bg-white p-3 text-sm shadow-lg z-40">
                            <p class="mb-3 truncate text-xs uppercase text-slate-400">{{ auth()->user()->name ?? 'Usuário' }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left font-semibold text-rose-600 hover:bg-rose-50">
                                    <span class="inline-flex h-5 w-5 items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0-4 4m4-4-4-4m6-2V5a2 2 0 00-2-2H7" />
                                        </svg>
                                    </span>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </details>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 md:px-8">
            @yield('content')
        </main>

        <footer class="px-4 pb-8 md:px-8">
            <div class="glass-card mx-auto max-w-7xl px-6 py-4 text-sm text-slate-500">
                © {{ now()->format('Y') }} KL PDV · Controle inteligente de vendas e estoque.
            </div>
        </footer>
    </body>
</html>
