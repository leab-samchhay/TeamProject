<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // SalesController.php

public function index(Request $request)
{
    $query = Product::with(['category', 'supplier', 'unitype']);

    if ($request->filled('search')) {
        $query->where('ProName', 'like', '%' . $request->search . '%')
              ->orWhere('ProNameKh', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category_id')) {
        $query->where('CategoryID', $request->category_id);
    }

    // ប្រើឈ្មោះ $rows សម្រាប់ Product
    $rows = $query->latest()->paginate(12);

    $invoices = Invoice::with(['customer', 'user', 'exchange.fromCurrency', 'exchange.toCurrency'])
        ->latest()
        ->paginate(10);

    $categories = Category::orderBy('name')->get();
    $customers  = Customer::where('status', 1)->get();
    $users      = User::where('status', 1)->get();
    $invoice    = Invoice::first();
    $exchanges  = Exchange::with(['fromCurrency', 'toCurrency'])
        ->where('status', 1)
        ->get();

    // បោះ $rows ទៅ View
    return view('sale.index', compact(
        'rows',
        'invoices',
        'categories',
        'customers',
        'users',
        'exchanges',
        'invoice'
    ));
}
}
