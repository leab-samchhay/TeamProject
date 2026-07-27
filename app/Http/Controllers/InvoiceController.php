<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Exchange;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $rows = Invoice::with(['customer', 'user', 'exchange.fromCurrency', 'exchange.toCurrency'])
            ->latest()
            ->paginate(10);

        return view('invoice.index', compact('rows'));
    }

    public function create()
    {
        $customers = Customer::where('status', 1)->get();
        $users     = User::where('status', 1)->get();
        $exchanges = Exchange::with(['fromCurrency', 'toCurrency'])
            ->where('status', 1)
            ->get();

        return view('invoice.create', compact('customers', 'users', 'exchanges'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'invoiceDate' => 'required|date',
            'discound'    => 'required|integer',
            'total'       => 'required|numeric',
            'status'      => 'nullable|integer',
            'CustomerID'  => 'required|exists:customers,id',
            'UserID'      => 'required|exists:users,id',
            'ExchangeID'  => 'required|exists:exchanges,id',
        ]);

        Invoice::create($validate);

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        //
    }

    public function edit(int $id)
    {
        $invoice   = Invoice::findOrFail($id);
        $customers = Customer::where('status', 1)->get();
        $users     = User::where('status', 1)->get();
        $exchanges = Exchange::with(['fromCurrency', 'toCurrency'])
            ->where('status', 1)
            ->get();

        return view('invoice.edit', compact('invoice', 'customers', 'users', 'exchanges'));
    }

    public function update(Request $request, int $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validate = $request->validate([
            'invoiceDate' => 'required|date',
            'discound'    => 'required|integer',
            'total'       => 'required|numeric',
            'status'      => 'nullable|integer',
            'CustomerID'  => 'required|exists:customers,id',
            'UserID'      => 'required|exists:users,id',
            'ExchangeID'  => 'required|exists:exchanges,id',
        ]);

        $invoice->update($validate);

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
