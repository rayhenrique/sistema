@extends('layouts.app')

@section('title', 'Pedido ' . $order->code . ' · KL PDV')

@section('content')
    <div class="space-y-6">
        <div class="glass-card border border-slate-200/70 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">Pedido de vendas</p>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $order->code }}</h1>
                    <p class="text-sm text-slate-500">Cliente: {{ $order->customer->name }}</p>
                </div>
                <div class="flex gap-3">
                    <button class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">
                        Imprimir A4
                    </button>
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">
                        Imprimir Cupom
                    </button>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-4">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Status do pedido</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ ucfirst($order->status) }}</p>
                    <p class="text-xs text-slate-500">Remessa: {{ ucfirst($order->shipping_status) }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Pagamento</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ ucfirst($order->payment_status) }}</p>
                    <p class="text-xs text-slate-500">{{ $order->payments->count() }} parcelas</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Total</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                    <p class="text-xs text-slate-500">Descontos: R$ {{ number_format($order->discount, 2, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase text-slate-500">Previsão de envio</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">
                        {{ optional($order->expected_shipping_at)->translatedFormat('d/m/Y') ?? '—' }}
                    </p>
                    <p class="text-xs text-slate-500">Entrega estimada</p>
                </div>
            </div>
        </div>

        <div class="glass-card border border-slate-200/70 p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Itens do pedido</h2>
                <p class="text-sm text-slate-500">{{ $order->items->count() }} itens</p>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead>
                        <tr class="text-xs font-semibold uppercase text-slate-500">
                            <th class="px-3 py-2">Produto</th>
                            <th class="px-3 py-2">Qtd.</th>
                            <th class="px-3 py-2">Preço unitário</th>
                            <th class="px-3 py-2">Desconto</th>
                            <th class="px-3 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-3 py-3">
                                    <p class="font-semibold text-slate-900">{{ $item->product->name }}</p>
                                    <p class="text-xs text-slate-500">SKU {{ $item->product->sku }}</p>
                                </td>
                                <td class="px-3 py-3">{{ $item->quantity }}</td>
                                <td class="px-3 py-3">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td class="px-3 py-3">R$ {{ number_format($item->discount, 2, ',', '.') }}</td>
                                <td class="px-3 py-3 font-semibold text-slate-900">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="glass-card border border-slate-200/70 p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Parcelas / Contas a receber</h2>
                <a href="{{ route('payments.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Ver todas</a>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
                @foreach ($order->payments as $payment)
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase text-slate-500">{{ strtoupper($payment->method) }}</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">R$ {{ number_format($payment->amount, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-500">Vencimento: {{ optional($payment->due_date)->translatedFormat('d/m/Y') }}</p>
                        <p class="text-xs font-semibold text-slate-600">Status: {{ ucfirst($payment->status) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
