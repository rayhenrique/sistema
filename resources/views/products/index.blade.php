@extends('layouts.app')

@section('title', 'Produtos · KL PDV')

@section('content')
    <div class="glass-card border border-slate-200/70 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500">Gestão de produtos</p>
                <h1 class="text-2xl font-bold text-slate-900">Catálogo e estoque</h1>
                <p class="text-sm text-slate-500">Margens, estoque mínimo e fornecedores integrados.</p>
            </div>
            <form method="GET" class="flex flex-col gap-2 text-sm md:flex-row md:items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome ou SKU"
                    class="rounded-xl border border-slate-200 px-3 py-2 focus:border-indigo-500 focus:outline-none">
                <label class="flex items-center gap-2 text-xs font-semibold uppercase text-slate-500">
                    <input type="checkbox" name="low_stock" value="1" @checked(request()->boolean('low_stock'))
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    Apenas itens com estoque crítico
                </label>
                <button class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">Filtrar</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase text-slate-500">
                        <th class="px-3 py-2">Produto</th>
                        <th class="px-3 py-2">Fornecedor</th>
                        <th class="px-3 py-2">Estoque</th>
                        <th class="px-3 py-2">Preço</th>
                        <th class="px-3 py-2">Margem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3">
                                <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">SKU {{ $product->sku }}</p>
                            </td>
                            <td class="px-3 py-3 text-sm text-slate-900">{{ $product->supplier->name ?? '—' }}</td>
                            <td class="px-3 py-3 text-sm">
                                <span class="font-semibold text-slate-900">{{ $product->stock_quantity }}</span>
                                <span class="text-xs text-slate-500">mín {{ $product->stock_minimum }}</span>
                            </td>
                            <td class="px-3 py-3 font-semibold text-slate-900">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-sm text-slate-900">{{ $product->margin }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-4 text-center text-sm text-slate-500">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
