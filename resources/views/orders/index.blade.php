@extends('layouts.app')

@section('title', 'Pedidos · KL PDV')

@section('content')
    <div class="glass-card border border-slate-200/70 p-6 space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Gestao de vendas</p>
                <h1 class="text-2xl font-bold text-slate-900">Pedidos</h1>
                <p class="text-sm text-slate-500">Controle o status, emissao e impressao de pedidos.</p>
            </div>
            <a href="{{ route('orders.pos') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-indigo-600">
                <span class="inline-flex h-4 w-4 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                Abrir PDV
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                @if ($currentRegister)
                    <p class="text-xs font-semibold uppercase text-emerald-600">Caixa aberto</p>
                    <p class="text-sm text-slate-500">Aberto em {{ $currentRegister->opened_at->translatedFormat('d/m/Y H:i') }}</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        Saldo inicial R$ {{ number_format($currentRegister->opening_balance, 2, ',', '.') }}
                    </p>
                    <form action="{{ route('cash-register.close') }}" method="POST" class="mt-4 grid gap-3 text-sm md:grid-cols-3">
                        @csrf
                        <input type="number" step="0.01" name="closing_balance" placeholder="Saldo final"
                            class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none" required>
                        <input type="text" name="notes" placeholder="Observacoes"
                            class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none md:col-span-2">
                        <button type="submit"
                            class="rounded-xl bg-rose-600 px-4 py-2 font-semibold text-white hover:bg-rose-500 md:col-span-3">
                            Fechar caixa
                        </button>
                    </form>
                @else
                    <p class="text-xs font-semibold uppercase text-rose-500">Caixa fechado</p>
                    <p class="text-sm text-slate-500">Abra um caixa para iniciar vendas via PDV.</p>
                    <form action="{{ route('cash-register.open') }}" method="POST" class="mt-4 grid gap-3 text-sm md:grid-cols-3">
                        @csrf
                        <input type="number" step="0.01" name="opening_balance" placeholder="Saldo inicial"
                            class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none" required>
                        <input type="text" name="notes" placeholder="Observacoes"
                            class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none md:col-span-2">
                        <button type="submit"
                            class="rounded-xl bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-500 md:col-span-3">
                            Abrir caixa
                        </button>
                    </form>
                @endif
            </div>
            <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <p class="text-xs font-semibold uppercase text-slate-500">Ultimo fechamento</p>
                @if ($lastClosedRegister)
                    <p class="text-sm text-slate-500">Fechado em {{ $lastClosedRegister->closed_at->translatedFormat('d/m/Y H:i') }}</p>
                    <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-500">Saldo inicial</p>
                            <p class="text-lg font-semibold text-slate-900">R$ {{ number_format($lastClosedRegister->opening_balance, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Saldo final</p>
                            <p class="text-lg font-semibold text-slate-900">R$ {{ number_format($lastClosedRegister->closing_balance ?? 0, 2, ',', '.') }}</p>
                        </div>
                    </div>
                @else
                    <p class="mt-2 text-sm text-slate-500">Nenhum fechamento registrado ainda.</p>
                @endif
            </div>
        </div>

        <form method="GET" class="flex flex-col gap-2 text-sm md:flex-row md:items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar codigo ou cliente"
                class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
            <select name="status"
                class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                <option value="">Status do pedido</option>
                @foreach (['draft' => 'Rascunho', 'pending' => 'Pendente', 'processing' => 'Separacao', 'shipped' => 'Enviado', 'delivered' => 'Concluido', 'cancelled' => 'Cancelado'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="payment_status"
                class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                <option value="">Status financeiro</option>
                @foreach (['pending' => 'Pendente', 'partial' => 'Parcial', 'paid' => 'Pago', 'overdue' => 'Em atraso'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('payment_status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-500">
                Filtrar
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Pedido</th>
                        <th class="px-3 py-2">Cliente</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Pagamento</th>
                        <th class="px-3 py-2">Canal</th>
                        <th class="px-3 py-2">Total</th>
                        <th class="px-3 py-2 text-right">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $order->code }}</td>
                            <td class="px-3 py-3">
                                <p class="font-medium text-slate-900">{{ $order->customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $order->created_at->translatedFormat('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-xs text-slate-500">Remessa: {{ ucfirst($order->shipping_status) }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <p class="text-xs text-slate-500">{{ $order->payments->count() }} parcelas</p>
                            </td>
                            <td class="px-3 py-3 text-xs uppercase text-slate-500">
                                {{ $order->channel === 'pdv' ? 'PDV' : 'ERP' }}
                            </td>
                            <td class="px-3 py-3 font-semibold text-slate-900">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-right">
                                <a href="{{ route('orders.show', $order) }}"
                                    class="text-sm font-semibold text-indigo-600 hover:underline">
                                    Visualizar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
