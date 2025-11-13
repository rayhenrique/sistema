@extends('layouts.guest')

@section('title', 'Entrar no KL PDV')

@section('content')
    <section class="grid gap-10 lg:grid-cols-2">
        <div class="glass-card border border-slate-200/70 px-8 py-10">
            <div class="space-y-2 text-center">
                <p class="pill mx-auto bg-white/40 text-indigo-500">Acesso seguro</p>
                <h1 class="text-3xl font-bold text-slate-900">Bem-vindo ao KL PDV</h1>
                <p class="text-sm text-slate-500">
                    Utilize seu e-mail corporativo e senha. Para testes, use admin@klpdv.local / klpdv123.
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-700">E-mail</label>
                    <input
                        id="email"
                        type="email"
                        placeholder="voce@empresa.com"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-2xl border border-slate-300 bg-white/70 px-4 py-3 text-sm text-slate-900 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-700">Senha</label>
                    <input
                        id="password"
                        type="password"
                        placeholder="********"
                        name="password"
                        required
                        class="w-full rounded-2xl border border-slate-300 bg-white/70 px-4 py-3 text-sm text-slate-900 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        Lembrar meu acesso
                    </label>
                    <a href="#" class="font-semibold text-indigo-600 hover:underline">Esqueci minha senha</a>
                </div>
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:translate-y-0.5"
                >
                    Entrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">
                Não possui acesso? Solicite ao administrador ou teste usando as credenciais demo.
            </p>
        </div>

        <div class="glass-card border border-indigo-200/80 bg-gradient-to-br from-indigo-50 to-white px-8 py-10">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-500">Por que o KL PDV?</p>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">Experiência fluida para sua equipe</h2>
            <ul class="mt-6 space-y-4 text-sm text-slate-600">
                <li class="flex gap-3">
                    <span class="rounded-full bg-white/70 px-2 py-1 text-xs font-semibold text-indigo-600">UX</span>
                    Interface responsiva com cartões, gráficos e filtros acessíveis de qualquer dispositivo.
                </li>
                <li class="flex gap-3">
                    <span class="rounded-full bg-white/70 px-2 py-1 text-xs font-semibold text-indigo-600">Segurança</span>
                    Autenticação por perfil e logs de atividade para proteger dados sensíveis.
                </li>
                <li class="flex gap-3">
                    <span class="rounded-full bg-white/70 px-2 py-1 text-xs font-semibold text-indigo-600">Produtividade</span>
                    Acesso rápido a pedidos, estoque e financeiro em um só fluxo.
                </li>
            </ul>
            <div class="mt-8 rounded-2xl border border-white/60 bg-white/60 p-4 text-sm text-slate-700">
                <p class="font-semibold text-slate-900">Acesso demo imediato</p>
                <p>admin@klpdv.local · klpdv123</p>
            </div>
        </div>
    </section>
@endsection
