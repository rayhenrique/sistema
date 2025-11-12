<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['customer', 'payments'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->payment_status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('code', 'like', '%' . $request->search . '%')
                        ->orWhereHas('customer', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product', 'payments']);

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
