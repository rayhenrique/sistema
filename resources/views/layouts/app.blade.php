<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'KL PDV')</title>
        @vite(['resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <header class="bg-white shadow">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500">KL PDV</p>
                    <h1 class="text-2xl font-bold text-slate-900">Painel de Controle</h1>
                </div>
                <nav class="flex gap-4 text-sm font-medium text-slate-600">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Dashboard</a>
                    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Pedidos</a>
                    <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Clientes</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Produtos</a>
                    <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Fornecedores</a>
                    <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'text-indigo-600' : 'hover:text-slate-900' }}">Contas a Receber</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-8">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-6 py-4 text-sm text-slate-500">
                © {{ now()->format('Y') }} KL PDV · Controle inteligente de vendas e estoque.
            </div>
        </footer>
    </body>
</html>
