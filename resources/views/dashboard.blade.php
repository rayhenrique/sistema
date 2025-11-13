@extends('layouts.app')

@section('title', 'Dashboard · KL PDV')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @php
            $cards = [
                [
                    'title' => 'Faturamento recebido',
                    'value' => 'R$ ' . number_format($metrics['total_revenue'], 2, ',', '.'),
                    'description' => 'Pagamentos marcados como pagos',
                    'accent' => 'text-emerald-600',
                ],
                [
                    'title' => 'Contas a receber',
                    'value' => 'R$ ' . number_format($metrics['pending_receivables'], 2, ',', '.'),
                    'description' => 'Parcelas pendentes ou em atraso',
                    'accent' => 'text-amber-600',
                ],
                [
                    'title' => 'Valor em estoque',
                    'value' => 'R$ ' . number_format($metrics['inventory_value'], 2, ',', '.'),
                    'description' => 'Preço de venda x quantidade',
                    'accent' => 'text-slate-500',
                ],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="glass-card border border-slate-200/70 p-4">
                <p class="text-xs font-semibold uppercase text-slate-500">{{ $card['title'] }}</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $card['value'] }}</p>
                <p class="text-xs {{ $card['accent'] }}">{{ $card['description'] }}</p>
            </div>
        @endforeach

        <div class="glass-card border border-slate-200/70 p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Cadastros ativos</p>
            <div class="mt-3 flex items-end gap-4 text-sm">
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $metrics['customers'] }}</p>
                    <p class="text-xs text-slate-500">Clientes</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $metrics['products'] }}</p>
                    <p class="text-xs text-slate-500">Produtos</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $metrics['suppliers'] }}</p>
                    <p class="text-xs text-slate-500">Fornecedores</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="glass-card border border-slate-200/70">
                <div class="border-b border-slate-200/70 px-6 py-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Geração de pedidos</p>
                            <h2 class="text-lg font-semibold text-slate-900">Últimos pedidos</h2>
                        </div>
                        <a href="{{ route('orders.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">Ver todos</a>
                    </div>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestOrders as $order)
                        <div class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $order->code }} · {{ $order->customer->name }}</p>
                                <p class="text-xs text-slate-500">
                                    R$ {{ number_format($order->total, 2, ',', '.') }} · Status:
                                    <span class="font-medium text-slate-900">{{ ucfirst($order->status) }}</span>
                                </p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-indigo-600 hover:underline">Detalhes</a>
                        </div>
                    @empty
                        <p class="px-6 py-4 text-sm text-slate-500">Nenhum pedido registrado.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card border border-slate-200/70">
                <div class="border-b border-slate-200/70 px-6 py-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Clientes</p>
                            <h2 class="text-lg font-semibold text-slate-900">Top clientes por faturamento</h2>
                        </div>
                        <a href="{{ route('customers.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">Ver clientes</a>
                    </div>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($topCustomers as $customer)
                        <div class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $customer->orders_count }} pedidos</p>
                            </div>
                            <p class="text-sm font-semibold text-slate-900">R$ {{ number_format($customer->total_spent ?? 0, 2, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="px-6 py-4 text-sm text-slate-500">Nenhum cliente disponível.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass-card border border-slate-200/70">
                <div class="border-b border-slate-200/70 px-6 py-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Estoque</p>
                    <h2 class="text-lg font-semibold text-slate-900">Produtos com necessidade de reposição</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($lowStockProducts as $product)
                        <div class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $product->name }}</p>
                            <p class="text-xs text-slate-500">
                                Atual: {{ $product->stock_quantity }} · Mínimo: {{ $product->stock_minimum }}
                                @if ($product->supplier)
                                    · Fornecedor: {{ $product->supplier->name }}
                                @endif
                            </p>
                        </div>
                    @empty
                        <p class="px-6 py-4 text-sm text-slate-500">Nenhum produto com estoque crítico.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card border border-slate-200/70">
                <div class="border-b border-slate-200/70 px-6 py-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Contas a receber</p>
                    <h2 class="text-lg font-semibold text-slate-900">Pagamentos pendentes</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($pendingPayments as $payment)
                        <div class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $payment->reference ?? $payment->order->code }}</p>
                            <p class="text-xs text-slate-500">
                                {{ $payment->order->customer->name }} · Vence em
                                {{ \Carbon\Carbon::parse($payment->due_date)->translatedFormat('d/m/Y') }}
                            </p>
                            <p class="text-sm font-semibold text-amber-600">
                                R$ {{ number_format($payment->amount, 2, ',', '.') }} · {{ strtoupper($payment->method) }}
                            </p>
                        </div>
                    @empty
                        <p class="px-6 py-4 text-sm text-slate-500">Nenhuma parcela pendente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
