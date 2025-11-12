@extends('layouts.app')

@section('title', 'Contas a receber · KL PDV')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Financeiro</p>
                <h1 class="text-2xl font-bold text-slate-900">Contas a receber</h1>
                <p class="text-sm text-slate-500">Controle parcelas, métodos de pagamento e inadimplência.</p>
            </div>
            <form method="GET" class="flex flex-col gap-2 text-sm md:flex-row md:items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cliente ou referência"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                <select name="status"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                    <option value="">Status</option>
                    @foreach (['pending' => 'Pendente', 'paid' => 'Pago', 'overdue' => 'Em atraso', 'cancelled' => 'Cancelado'] as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="method"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                    <option value="">Forma de pagamento</option>
                    @foreach (['pix', 'boleto', 'promissoria', 'dinheiro', 'cartao_credito', 'cartao_debito', 'cheque'] as $method)
                        <option value="{{ $method }}" @selected(request('method') === $method)>{{ strtoupper($method) }}</option>
                    @endforeach
                </select>
                <button class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">Filtrar</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Referência</th>
                        <th class="px-3 py-2">Cliente</th>
                        <th class="px-3 py-2">Vencimento</th>
                        <th class="px-3 py-2">Valor</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3">
                                <p class="font-semibold text-slate-900">{{ $payment->reference ?? $payment->order->code }}</p>
                                <p class="text-xs text-slate-500">{{ strtoupper($payment->method) }}</p>
                            </td>
                            <td class="px-3 py-3 text-sm text-slate-900">{{ $payment->order->customer->name }}</td>
                            <td class="px-3 py-3 text-sm text-slate-900">
                                {{ optional($payment->due_date)->translatedFormat('d/m/Y') }}
                                <span class="block text-xs text-slate-500">
                                    @if ($payment->paid_at)
                                        Pago em {{ $payment->paid_at->translatedFormat('d/m/Y') }}
                                    @else
                                        {{ $payment->status === 'overdue' ? 'Em atraso' : 'Aguardando' }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-3 py-3 font-semibold text-slate-900">R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                            <td class="px-3 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum título localizado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
@endsection
