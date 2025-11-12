<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->with('order.customer')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('method'), fn ($query) => $query->where('method', $request->method))
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('reference', 'like', '%' . $request->search . '%')
                        ->orWhereHas('order.customer', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                });
            })
            ->orderByDesc('due_date')
            ->paginate(15)
            ->withQueryString();

        return view('payments.index', [
            'payments' => $payments,
        ]);
    }
}
