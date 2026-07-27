<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = InvoiceDetail::with(['invoice', 'product'])
            ->latest()
            ->paginate(10);

        return view('invoiceDetail.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::where('status',1)->get();
        $products = Product::where('status',1)->get();
        return view('invoiceDetail.create',compact('invoices','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'InvoiceID' => 'required|exists:invoices,id',
            'ProductID' => 'required|exists:products,id',
            'qty'       => 'required|integer',
            'price'     => 'required|decimal:2',
            'cost'      => 'required|decimal:2',
            'totalPay'  => 'required|decimal:2',
            'discound'  => 'required|integer'

        ]);

        InvoiceDetail::create($validate);

        return redirect()->route('invoiceDetail.index')->with('Success full');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $invoices = Invoice::where('status',1)->get();
        $products = Product::where('status',1)->get();
        $invoiceDetail = InvoiceDetail::findOrFail($id);
        return view('invoiceDetail.edit',compact('invoices','invoiceDetail','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $invoiceDetail = InvoiceDetail::findOrFail($id);
        $validate = $request->validate([
            'InvoiceID' => 'required|exists:invoices,id',
            'ProductID' => 'required|exists:products,id',
            'qty'       => 'required|integer',
            'price'     => 'required|decimal:2',
            'cost'      => 'required|decimal:2',
            'totalPay'  => 'required|decimal:6',
            'discound'  => 'required|integer'

        ]);

        $invoiceDetail->update($validate);

        return redirect()->route('invoiceDetail.index')->with('success full');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $invoiceDetail = InvoiceDetail::findOrFail($id);
        $invoiceDetail->delete();
        return redirect()->route('invoiceDetail.index')->with('success full');
    }
}
