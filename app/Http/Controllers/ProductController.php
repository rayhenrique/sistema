<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('supplier')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('sku', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->boolean('low_stock'), fn ($query) => $query->lowStock())
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
        ]);
    }
}
