<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $register = $user->cashRegisters()->open()->latest()->first();

        return view('orders.pos', [
            'register' => $register,
            'customers' => Customer::orderBy('name')->get(['id', 'name']),
            'products' => Product::where('is_active', true)->orderBy('name')->limit(12)->get(['id', 'name', 'sku', 'price', 'stock_quantity']),
        ]);
    }

    public function products(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('sku', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('name')
            ->limit(25)
            ->get(['id', 'name', 'sku', 'price', 'stock_quantity']);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $register = $request->user()->cashRegisters()->open()->latest()->first();

        if (! $register) {
            return response()->json(['message' => 'Abra um caixa antes de registrar vendas.'], 422);
        }

        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(['pix', 'boleto', 'promissoria', 'dinheiro', 'cartao_credito', 'cartao_debito', 'cheque', 'outro'])],
            'notes' => ['nullable', 'string'],
        ]);

        $productIds = collect($data['items'])->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $product = $products->get($item['product_id']);
            if (! $product) {
                return response()->json(['message' => 'Produto inválido.'], 422);
            }

            if ($product->stock_quantity < $item['quantity']) {
                return response()->json(['message' => "Estoque insuficiente para {$product->name}."], 422);
            }

            $subtotal += $item['unit_price'] * $item['quantity'];
        }

        $discount = $data['discount'] ?? 0;
        $total = max($subtotal - $discount, 0);

        $order = DB::transaction(function () use ($data, $subtotal, $discount, $total, $products, $register) {
            $order = Order::create([
                'code' => $this->generateOrderCode(),
                'customer_id' => $data['customer_id'],
                'channel' => 'pdv',
                'status' => 'processing',
                'shipping_status' => 'pending',
                'payment_status' => 'paid',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $product = $products->get($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => 0,
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $data['payment_method'],
                'amount' => $total,
                'status' => 'paid',
                'paid_at' => now(),
                'reference' => $order->code . '-POS',
            ]);

            CashMovement::create([
                'cash_register_id' => $register->id,
                'user_id' => $register->user_id,
                'order_id' => $order->id,
                'type' => 'sale',
                'method' => $data['payment_method'],
                'amount' => $total,
                'description' => 'Venda PDV ' . $order->code,
                'occurred_at' => now(),
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Venda registrada com sucesso!',
            'order_id' => $order->id,
            'order_code' => $order->code,
        ]);
    }

    protected function generateOrderCode(): string
    {
        return 'PDV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
    }
}
