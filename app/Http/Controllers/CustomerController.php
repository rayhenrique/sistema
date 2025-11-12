<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->withCount('orders')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('document', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', [
            'customers' => $customers,
        ]);
    }
}
