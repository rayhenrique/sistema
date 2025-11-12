@extends('layouts.app')

@section('title', 'Fornecedores · KL PDV')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Gestão de fornecedores</p>
                <h1 class="text-2xl font-bold text-slate-900">Parceiros comerciais</h1>
                <p class="text-sm text-slate-500">Controle termos de pagamento e histórico de compras.</p>
            </div>
            <form method="GET" class="flex gap-2 text-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome, CNPJ ou e-mail"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none md:w-72">
                <button class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">Buscar</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Fornecedor</th>
                        <th class="px-3 py-2">Contato</th>
                        <th class="px-3 py-2">Endereço</th>
                        <th class="px-3 py-2">Produtos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3">
                                <p class="font-semibold text-slate-900">{{ $supplier->name }}</p>
                                <p class="text-xs text-slate-500">{{ $supplier->tax_id }}</p>
                            </td>
                            <td class="px-3 py-3 text-sm text-slate-900">
                                {{ $supplier->contact_name }} · {{ $supplier->phone }}<br>
                                <span class="text-xs text-slate-500">{{ $supplier->email }}</span>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500">
                                {{ $supplier->address }} - {{ $supplier->city }}/{{ $supplier->state }}
                            </td>
                            <td class="px-3 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ $supplier->products_count }} itens
                                </span>
                                <p class="text-xs text-slate-500">Condição: {{ $supplier->payment_terms ?? '—' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum fornecedor encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
