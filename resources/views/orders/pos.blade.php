@extends('layouts.app')

@section('title', 'PDV · KL PDV')

@section('content')
    <div class="space-y-6">
        <div class="glass-card border border-slate-200/70 p-6">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">Ponto de venda</p>
                    <h1 class="text-2xl font-bold text-slate-900">Caixa rapido</h1>
                    <p class="text-sm text-slate-500">Selecione produtos, confirme o pagamento e imprima o cupom nao fiscal.</p>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Voltar para pedidos</a>
            </div>
        </div>

        @if (! $register)
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-6">
                <p class="text-sm font-semibold text-rose-600">Nenhum caixa aberto.</p>
                <p class="text-sm text-rose-700 mt-1">Abra um caixa na tela de pedidos antes de usar o PDV.</p>
                <a href="{{ route('orders.index') }}" class="mt-4 inline-flex rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white">Abrir caixa</a>
            </div>
        @else
            <div
                id="pos-app"
                class="grid gap-6 lg:grid-cols-[2fr_1fr]"
                data-products='@json($products)'
                data-store-url="{{ route('orders.pos.store') }}"
                data-products-url="{{ route('orders.pos.products') }}"
                data-token="{{ csrf_token() }}"
                data-app-name="{{ config('app.name', 'KL PDV') }}"
            >
                <div class="space-y-6">
                    <div class="glass-card border border-slate-200/70 p-4">
                        <p class="text-xs font-semibold uppercase text-emerald-600">Caixa aberto</p>
                        <p class="text-sm text-slate-500">Aberto em {{ $register->opened_at->translatedFormat('d/m/Y H:i') }}</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900">Saldo inicial: R$ {{ number_format($register->opening_balance, 2, ',', '.') }}</p>
                    </div>

                    <div class="glass-card border border-slate-200/70 p-4 space-y-4">
                        <div class="grid gap-3 md:grid-cols-2">
                            <div>
                                <label for="customer_id" class="text-xs font-semibold uppercase text-slate-500">Cliente</label>
                                <select id="customer_id" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
                                    <option value="">Selecione</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="notes" class="text-xs font-semibold uppercase text-slate-500">Observacoes</label>
                                <input id="notes" type="text" placeholder="Ex: Pedido balcão"
                                    class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-xs font-semibold uppercase text-slate-500">Adicionar produtos</label>
                            <input type="text" id="product-search" placeholder="Nome ou SKU"
                                class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
                            <div id="product-results" class="grid gap-3 md:grid-cols-2"></div>
                        </div>
                    </div>

                    <div class="glass-card border border-slate-200/70 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-slate-700">Itens do carrinho</p>
                            <button type="button" id="clear-cart" class="text-xs font-semibold text-rose-600 hover:underline">Limpar</button>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-left text-sm" id="cart-table">
                                <thead>
                                    <tr class="text-xs uppercase text-slate-500">
                                        <th class="py-2">Produto</th>
                                        <th class="py-2">Qtd.</th>
                                        <th class="py-2">Unit.</th>
                                        <th class="py-2">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="glass-card border border-slate-200/70 p-4 space-y-4">
                        <div>
                            <label class="text-xs font-semibold uppercase text-slate-500">Forma de pagamento</label>
                            <div id="payment-buttons" class="mt-2 grid grid-cols-2 gap-2 text-sm">
                                @foreach (['dinheiro' => 'Dinheiro', 'pix' => 'PIX', 'cartao_credito' => 'Cartao credito', 'cartao_debito' => 'Cartao debito', 'boleto' => 'Boleto', 'promissoria' => 'Promissoria', 'cheque' => 'Cheque', 'outro' => 'Outro'] as $value => $label)
                                    <button type="button" data-method="{{ $value }}"
                                        class="payment-option rounded-2xl border border-slate-200 px-3 py-2 font-semibold text-slate-600 hover:border-indigo-500">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="payment_method" value="dinheiro">
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase text-slate-500">Desconto</label>
                            <input type="number" step="0.01" id="discount" value="0"
                                class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                        <div class="rounded-2xl bg-slate-900/90 p-4 text-white">
                            <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">Total</p>
                            <p class="text-3xl font-bold" id="total-display">R$ 0,00</p>
                            <p class="text-xs text-indigo-100" id="subtotal-display">Subtotal R$ 0,00</p>
                        </div>
                        <button type="button" id="finish-sale"
                            class="w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:translate-y-0.5">
                            Confirmar forma de pagamento
                        </button>
                        <p id="pos-message" class="text-sm"></p>
                    </div>
                </div>
            </div>

            <div id="payment-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
                <div class="w-full max-w-md rounded-3xl bg-white p-6 text-sm shadow-2xl">
                    <h2 class="text-lg font-semibold text-slate-900">Confirmar venda</h2>
                    <p class="mt-1 text-slate-500">Revise pagamento e confirme para gerar o cupom.</p>
                    <dl class="mt-4 space-y-2 text-slate-700">
                        <div class="flex justify-between">
                            <dt>Cliente:</dt>
                            <dd id="modal-customer" class="font-semibold"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Pagamento:</dt>
                            <dd id="modal-payment" class="font-semibold"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Itens:</dt>
                            <dd id="modal-items" class="font-semibold"></dd>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-slate-900">
                            <dt>Total:</dt>
                            <dd id="modal-total"></dd>
                        </div>
                    </dl>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <button id="confirm-payment"
                            class="flex-1 rounded-2xl bg-slate-900 px-4 py-2 font-semibold text-white hover:bg-indigo-600">
                            Registrar e imprimir
                        </button>
                        <button id="cancel-payment"
                            class="flex-1 rounded-2xl border border-slate-200 px-4 py-2 font-semibold text-slate-700 hover:border-slate-400">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($register)
        <script>
            (() => {
                const root = document.getElementById('pos-app');
                if (!root) return;

                const productsUrl = root.dataset.productsUrl;
                const storeUrl = root.dataset.storeUrl;
                const csrf = root.dataset.token;
                const appName = root.dataset.appName;
                const initialProducts = JSON.parse(root.dataset.products);

                const productResults = document.getElementById('product-results');
                const searchInput = document.getElementById('product-search');
                const cartTableBody = document.querySelector('#cart-table tbody');
                const customerSelect = document.getElementById('customer_id');
                const paymentMethod = document.getElementById('payment_method');
                const discountInput = document.getElementById('discount');
                const notesInput = document.getElementById('notes');
                const totalDisplay = document.getElementById('total-display');
                const subtotalDisplay = document.getElementById('subtotal-display');
                const messageBox = document.getElementById('pos-message');
                const confirmModal = document.getElementById('payment-confirm-modal');
                const modalCustomer = document.getElementById('modal-customer');
                const modalPayment = document.getElementById('modal-payment');
                const modalItems = document.getElementById('modal-items');
                const modalTotal = document.getElementById('modal-total');
                const confirmBtn = document.getElementById('confirm-payment');
                const cancelBtn = document.getElementById('cancel-payment');
                const paymentButtons = Array.from(document.querySelectorAll('.payment-option'));
                let cart = [];
                let pendingPayload = null;

                function formatMoney(value) {
                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
                }

                function renderProducts(list) {
                    productResults.innerHTML = '';
                    list.forEach(product => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'flex items-center justify-between rounded-2xl border border-slate-200 px-3 py-2 text-left text-sm hover:border-indigo-500';
                        button.innerHTML = `
                            <div>
                                <p class="font-semibold text-slate-900">${product.name}</p>
                                <p class="text-xs text-slate-500">SKU ${product.sku ?? '-'}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-slate-900">${formatMoney(product.price)}</p>
                                <p class="text-xs text-slate-500">Estoque ${product.stock_quantity}</p>
                            </div>
                        `;
                        button.addEventListener('click', () => addToCart(product));
                        productResults.appendChild(button);
                    });
                }

                function addToCart(product) {
                    const existing = cart.find(item => item.product_id === product.id);
                    if (existing) {
                        existing.quantity += 1;
                    } else {
                        cart.push({
                            product_id: product.id,
                            name: product.name,
                            unit_price: parseFloat(product.price),
                            quantity: 1,
                            stock: product.stock_quantity,
                        });
                    }
                    renderCart();
                }

                function renderCart() {
                    cartTableBody.innerHTML = '';
                    cart.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="py-2 text-slate-900">${item.name}</td>
                            <td class="py-2">
                                <input type="number" min="1" value="${item.quantity}" data-index="${index}"
                                    class="w-16 rounded-xl border border-slate-200 px-2 py-1 text-sm focus:border-indigo-500 focus:outline-none">
                            </td>
                            <td class="py-2 text-slate-700">${formatMoney(item.unit_price)}</td>
                            <td class="py-2 font-semibold text-slate-900">${formatMoney(item.unit_price * item.quantity)}</td>
                            <td class="py-2 text-right">
                                <button type="button" data-remove="${index}" class="text-sm font-semibold text-rose-600 hover:underline">Remover</button>
                            </td>
                        `;
                        cartTableBody.appendChild(row);
                    });

                    cartTableBody.querySelectorAll('input[data-index]').forEach(input => {
                        input.addEventListener('change', (event) => {
                            const idx = Number(event.target.dataset.index);
                            const value = Math.max(1, parseInt(event.target.value) || 1);
                            cart[idx].quantity = value;
                            renderCart();
                        });
                    });

                    cartTableBody.querySelectorAll('button[data-remove]').forEach(button => {
                        button.addEventListener('click', (event) => {
                            const idx = Number(event.target.dataset.remove);
                            cart.splice(idx, 1);
                            renderCart();
                        });
                    });

                    updateTotals();
                }

            (function initPaymentButtons() {
                    paymentButtons.forEach(button => {
                        if (button.dataset.method === paymentMethod.value) {
                            button.classList.add('border-indigo-500', 'text-indigo-600');
                        }
                        button.addEventListener('click', () => {
                            paymentButtons.forEach(btn => btn.classList.remove('border-indigo-500', 'text-indigo-600'));
                            button.classList.add('border-indigo-500', 'text-indigo-600');
                            paymentMethod.value = button.dataset.method;
                        });
                    });
                })();

                function updateTotals() {
                    const subtotal = cart.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);
                    const discount = parseFloat(discountInput.value || 0);
                    const total = Math.max(subtotal - discount, 0);
                    totalDisplay.textContent = formatMoney(total);
                    subtotalDisplay.textContent = `Subtotal ${formatMoney(subtotal)} - Desconto ${formatMoney(discount)}`;
                }

                function clearCart() {
                    cart = [];
                    renderCart();
                }

                document.getElementById('clear-cart').addEventListener('click', clearCart);
                discountInput.addEventListener('input', updateTotals);

                searchInput.addEventListener('input', (event) => {
                    const term = event.target.value.trim();
                    if (!term) {
                        renderProducts(initialProducts);
                        return;
                    }

                    fetch(`${productsUrl}?search=${encodeURIComponent(term)}`)
                        .then(response => response.json())
                        .then(renderProducts);
                });

                document.getElementById('finish-sale').addEventListener('click', () => {
                    if (!customerSelect.value) {
                        messageBox.textContent = 'Selecione um cliente.';
                        messageBox.className = 'text-sm text-rose-600';
                        return;
                    }
                    if (cart.length === 0) {
                        messageBox.textContent = 'Adicione produtos ao carrinho.';
                        messageBox.className = 'text-sm text-rose-600';
                        return;
                    }

                    pendingPayload = {
                        customer_id: customerSelect.value,
                        payment_method: paymentMethod.value,
                        discount: parseFloat(discountInput.value || 0),
                        notes: notesInput.value,
                        items: cart.map(item => ({
                            product_id: item.product_id,
                            quantity: item.quantity,
                            unit_price: item.unit_price,
                        })),
                    };

                    modalCustomer.textContent = customerSelect.options[customerSelect.selectedIndex].text;
                    modalPayment.textContent = paymentButtons
                        .find(btn => btn.dataset.method === paymentMethod.value)?.textContent?.trim() ?? paymentMethod.value;
                    modalItems.textContent = `${cart.length} item(ns)`;
                    modalTotal.textContent = totalDisplay.textContent;
                    confirmModal.classList.remove('hidden');
                    confirmModal.classList.add('flex');
                });

                confirmBtn.addEventListener('click', () => {
                    if (!pendingPayload) return;
                    confirmModal.classList.add('hidden');
                    confirmModal.classList.remove('flex');

                    fetch(storeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(pendingPayload),
                    })
                        .then(async (response) => {
                            const data = await response.json();
                            if (!response.ok) {
                                throw new Error(data.message || 'Erro ao finalizar venda.');
                            }
                            return data;
                        })
                        .then((data) => {
                            messageBox.textContent = data.message;
                            messageBox.className = 'text-sm text-emerald-600';
                            const receiptPayload = {
                                ...pendingPayload,
                                order_code: data.order_code,
                            };
                            printReceipt(receiptPayload);
                            pendingPayload = null;
                            clearCart();
                            notesInput.value = '';
                            discountInput.value = 0;
                            updateTotals();
                        })
                        .catch((error) => {
                            messageBox.textContent = error.message;
                            messageBox.className = 'text-sm text-rose-600';
                            pendingPayload = null;
                        });
                });

                cancelBtn.addEventListener('click', () => {
                    confirmModal.classList.add('hidden');
                    confirmModal.classList.remove('flex');
                    pendingPayload = null;
                });

                function printReceipt(payload) {
                    const snapshot = cart.map(item => ({
                        name: item.name,
                        quantity: item.quantity,
                        unit_price: item.unit_price,
                    }));
                    const subtotal = snapshot.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);
                    const discount = payload.discount || 0;
                    const total = Math.max(subtotal - discount, 0);
                    const itemsHtml = snapshot
                        .map(item => `<tr><td>${item.quantity}x ${item.name}</td><td>${formatMoney(item.unit_price * item.quantity)}</td></tr>`)
                        .join('');

                    const receipt = `
                        <html>
                            <head>
                                <title>${appName} - Cupom</title>
                                <style>
                                    body { font-family: Arial, sans-serif; font-size: 12px; margin: 16px; }
                                    h1 { font-size: 16px; margin: 0 0 10px 0; }
                                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                                    td { padding: 4px 0; border-bottom: 1px dashed #ccc; }
                                    .totals { margin-top: 10px; }
                                    .totals strong { display: block; }
                                </style>
                            </head>
                            <body>
                                <h1>${appName} - Cupom nao fiscal</h1>
                                <p>Pedido: ${payload.order_code}</p>
                                <p>Cliente: ${customerSelect.options[customerSelect.selectedIndex].text}</p>
                                <p>Pagamento: ${modalPayment.textContent}</p>
                                <table><tbody>${itemsHtml}</tbody></table>
                                <div class="totals">
                                    <strong>Subtotal: ${formatMoney(subtotal)}</strong>
                                    <strong>Desconto: ${formatMoney(discount)}</strong>
                                    <strong>Total: ${formatMoney(total)}</strong>
                                </div>
                                <p style="margin-top:20px;">Obrigado e volte sempre!</p>
                            </body>
                        </html>
                    `;

                    const win = window.open('', '_blank');
                    win.document.write(receipt);
                    win.document.close();
                    win.focus();
                    win.print();
                }

                renderProducts(initialProducts);
                renderCart();
            })();
        </script>
    @endif
@endsection
