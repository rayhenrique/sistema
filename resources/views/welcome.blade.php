@extends('layouts.guest')

@section('title', 'KL PDV · Solução completa para vendas e estoque')

@section('content')
    <section class="grid gap-10 lg:grid-cols-[1.1fr_.9fr]">
        <div class="space-y-8">
            <span class="pill bg-white/40 text-indigo-500">Solução completa para PMEs</span>
            <div class="space-y-4">
                <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                    Gestão moderna de pedidos, estoque e financeiro em um único painel.
                </h1>
                <p class="text-lg text-slate-600">
                    O KL PDV conecta vendedores, expedição e financeiro com insights em tempo real, integrações flexíveis
                    e fluxos automáticos para cada etapa do ciclo de vendas.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:translate-y-0.5"
                >
                    {{ auth()->check() ? 'Entrar no painel' : 'Começar agora' }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="#recursos" class="inline-flex items-center gap-2 rounded-2xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-indigo-500">
                    Ver recursos
                    <span aria-hidden="true">↓</span>
                </a>
            </div>
            <dl class="grid gap-4 sm:grid-cols-3">
                <div class="glass-card px-4 py-3">
                    <dt class="text-xs uppercase text-slate-500">Pedidos/mês</dt>
                    <dd class="text-2xl font-bold text-slate-900">+4.500</dd>
                </div>
                <div class="glass-card px-4 py-3">
                    <dt class="text-xs uppercase text-slate-500">Tempo economizado</dt>
                    <dd class="text-2xl font-bold text-slate-900">120h</dd>
                </div>
                <div class="glass-card px-4 py-3">
                    <dt class="text-xs uppercase text-slate-500">Empresas ativas</dt>
                    <dd class="text-2xl font-bold text-slate-900">35</dd>
                </div>
            </dl>
        </div>
        <div class="relative">
            <div class="absolute inset-x-6 inset-y-0 rounded-3xl bg-gradient-to-t from-indigo-500/20 to-slate-900/0 blur-3xl"></div>
            <div class="glass-card relative px-6 py-6">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>Visão rápida</span>
                    <span>Atualizado há 3 min</span>
                </div>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">Dashboard KL PDV</h2>
                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl bg-slate-900/90 px-4 py-3 text-white">
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">Hoje</p>
                        <p class="mt-1 text-2xl font-semibold">R$ 18.942,00</p>
                        <p class="text-xs text-indigo-100">Faturamento confirmado</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <article class="rounded-2xl border border-slate-200/70 bg-white/90 px-4 py-3">
                            <p class="text-xs uppercase text-slate-500">Pedidos aguardando envio</p>
                            <p class="mt-1 text-xl font-semibold text-slate-900">12</p>
                            <p class="text-xs text-slate-500">separação + transporte</p>
                        </article>
                        <article class="rounded-2xl border border-slate-200/70 bg-white/90 px-4 py-3">
                            <p class="text-xs uppercase text-slate-500">Reposições críticas</p>
                            <p class="mt-1 text-xl font-semibold text-rose-600">7 itens</p>
                            <p class="text-xs text-slate-500">estoque ≤ mínimo</p>
                        </article>
                    </div>
                    <article class="rounded-2xl border border-slate-200/70 bg-white/90 px-4 py-3">
                        <p class="text-xs uppercase text-slate-500">Recebíveis próximos</p>
                        <div class="mt-1 flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-900">R$ 32.110,15</span>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">+8 parcelas</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="recursos" class="mt-16 space-y-6">
        <span class="pill text-indigo-500">Recursos principais</span>
        <h2 class="text-3xl font-bold text-slate-900">Tudo o que você precisa para vender com agilidade</h2>
        <div class="grid gap-6 md:grid-cols-2">
            @php
                $features = [
                    ['title' => 'Geração de pedidos', 'description' => 'Cadastre itens, descontos e formas de pagamento com impressão em A4 ou cupom não fiscal.'],
                    ['title' => 'Controle de estoque', 'description' => 'Baixa automática por item, movimentações de entrada e alertas de reposição mínima.'],
                    ['title' => 'Contas a receber', 'description' => 'Parcelas em PIX, boleto, promissória ou cartão com status pendente, pago ou em atraso.'],
                    ['title' => 'Gestão de clientes e fornecedores', 'description' => 'Histórico de compras, termos de pagamento e contatos centralizados.'],
                ];
            @endphp
            @foreach ($features as $feature)
                <article class="glass-card border border-slate-200/70 px-6 py-6">
                    <h3 class="text-lg font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $feature['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="como-funciona" class="mt-16 grid gap-8 lg:grid-cols-2">
        <div class="glass-card border border-slate-200/70 px-6 py-6">
            <h3 class="text-xl font-semibold text-slate-900">Fluxo completo em 4 passos</h3>
            <ol class="mt-6 space-y-4 text-sm text-slate-600">
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-600">1</span>
                    Cadastre clientes, fornecedores e produtos com estoque mínimo e margens.
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-600">2</span>
                    Gere pedidos, aplique descontos e defina formas de pagamento.
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-600">3</span>
                    Acompanhe remessas, baixa de estoque automática e contas a receber.
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-600">4</span>
                    Utilize dashboards e relatórios para decidir reposições e metas comerciais.
                </li>
            </ol>
        </div>
        <div class="glass-card border border-indigo-200 bg-gradient-to-br from-indigo-50 to-white px-6 py-6">
            <h3 class="text-xl font-semibold text-slate-900">Teste com usuários demo</h3>
            <p class="mt-2 text-slate-600">Entre com um perfil pronto e explore todos os fluxos do KL PDV.</p>
            <ul class="mt-4 space-y-2 text-sm text-slate-700">
                <li class="flex justify-between rounded-2xl border border-white/60 bg-white/60 px-4 py-2">
                    <span>Administrador</span>
                    <span>admin@klpdv.local · klpdv123</span>
                </li>
                <li class="flex justify-between rounded-2xl border border-white/60 bg-white/60 px-4 py-2">
                    <span>Gerente</span>
                    <span>gerente@klpdv.local · klpdv123</span>
                </li>
            </ul>
            <a
                href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                class="mt-6 inline-flex rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-400/40"
            >
                {{ auth()->check() ? 'Abrir painel' : 'Ir para tela de login' }}
            </a>
        </div>
    </section>
@endsection
