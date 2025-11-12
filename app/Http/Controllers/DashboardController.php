<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $pendingReceivables = Payment::whereIn('status', ['pending', 'overdue'])->sum('amount');
        $inventoryValue = Product::select(DB::raw('SUM(price * stock_quantity) as value'))->value('value') ?? 0;

        $latestOrders = Order::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockProducts = Product::with('supplier')
            ->lowStock()
            ->orderBy('stock_quantity')
            ->limit(5)
            ->get();

        $pendingPayments = Payment::with('order.customer')
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        $topCustomers = Customer::withCount('orders')
            ->withSum('orders as total_spent', 'total')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'metrics' => [
                'total_revenue' => $totalRevenue,
                'pending_receivables' => $pendingReceivables,
                'inventory_value' => $inventoryValue,
                'customers' => Customer::count(),
                'orders' => Order::count(),
                'products' => Product::count(),
                'suppliers' => Supplier::count(),
            ],
            'latestOrders' => $latestOrders,
            'lowStockProducts' => $lowStockProducts,
            'pendingPayments' => $pendingPayments,
            'topCustomers' => $topCustomers,
        ]);
    }
}
