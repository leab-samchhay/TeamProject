<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseDetail;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = PurchaseDetail::with(['purchase'])->latest()->paginate(10);
        return view('purchaseDetail.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $purchase = Purchase::where('status', 1)->get();
        $product  = Product::where('status', 1)->get();

        return view('purchaseDetail.create', compact('purchase', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'qty'        => 'required|integer',
            'cost'       => 'required|numeric',
            'discount'   => 'required|integer',
            'purchaseID' => 'required|exists:purchases,id',
            'productID'  => 'required|exists:products,id',
        ]);

        PurchaseDetail::create($validate);

        return redirect()->route('purchaseDetail.index')->with('success', 'Purchase created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $purchaseDetail = PurchaseDetail::findOrFail($id);
        $purchase       = Purchase::where('status', 1)->get();
        $product        = Product::where('status', 1)->get();

        return view('purchaseDetail.edit', compact('purchaseDetail', 'purchase', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $purchaseDetail = PurchaseDetail::findOrFail($id);

        $validate = $request->validate([
            'qty'        => 'required|integer',
            'cost'       => 'required|numeric',
            'discount'   => 'required|integer',
            'purchaseID' => 'required|exists:purchases,id',
            'productID'  => 'required|exists:products,id',
        ]);

        $purchaseDetail->update($validate);

        return redirect()->route('purchaseDetail.index')->with('success', 'Purchase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $purchaseDetail = PurchaseDetail::findOrFail($id);
        $purchaseDetail->delete();
        return redirect()->route('purchaseDetail.index')->with('success', 'PurchaseDetail deleted successfully.');
    }
}
