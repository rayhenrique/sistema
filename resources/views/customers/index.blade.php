@extends('layouts.app')

@section('title', 'Clientes · KL PDV')

@section('content')
    <div class="glass-card border border-slate-200/70 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Gestão de clientes</p>
                <h1 class="text-2xl font-bold text-slate-900">Clientes cadastrados</h1>
                <p class="text-sm text-slate-500">Histórico de compras, dados de contato e relacionamento.</p>
            </div>
            <form method="GET" class="flex gap-2 text-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome, e-mail ou CPF/CNPJ"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none md:w-72">
                <button class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">Buscar</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Cliente</th>
                        <th class="px-3 py-2">Contato</th>
                        <th class="px-3 py-2">Endereço</th>
                        <th class="px-3 py-2">Pedidos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3">
                                <p class="font-semibold text-slate-900">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $customer->document }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <p class="text-sm text-slate-900">{{ $customer->email }}</p>
                                <p class="text-xs text-slate-500">{{ $customer->phone }}</p>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500">
                                {{ $customer->address }} - {{ $customer->city }}/{{ $customer->state }}
                            </td>
                            <td class="px-3 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ $customer->orders_count }} pedidos
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum cliente encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
@endsection
