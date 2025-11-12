@extends('layouts.app')

@section('title', 'Pedidos · KL PDV')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Gestão de vendas</p>
                <h1 class="text-2xl font-bold text-slate-900">Pedidos</h1>
                <p class="text-sm text-slate-500">Controle o status, emissão e impressão de pedidos.</p>
            </div>
            <form method="GET" class="flex flex-col gap-2 text-sm md:flex-row md:items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar código ou cliente"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                <select name="status"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                    <option value="">Status do pedido</option>
                    @foreach (['draft' => 'Rascunho', 'pending' => 'Pendente', 'processing' => 'Separação', 'shipped' => 'Enviado', 'delivered' => 'Concluído', 'cancelled' => 'Cancelado'] as $key => $label)
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
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Pedido</th>
                        <th class="px-3 py-2">Cliente</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Pagamento</th>
                        <th class="px-3 py-2">Total</th>
                        <th class="px-3 py-2 text-right">Ações</th>
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
                            <td class="px-3 py-3 font-semibold text-slate-900">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-right">
                                <a href="{{ route('orders.show', $order) }}" class="text-sm font-semibold text-indigo-600 hover:underline">
                                    Visualizar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum pedido encontrado.</td>
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
