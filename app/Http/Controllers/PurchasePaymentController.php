<?php

namespace App\Http\Controllers;

use App\Models\PurchasePayment;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    public function index()
    {
        $rows = PurchasePayment::with(['paymentMethod', 'purchase'])->paginate(10);
        return view('purchasePayment.index', compact('rows'));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $purchases = Purchase::all();
        return view('purchasePayment.create', compact('paymentMethods', 'purchases'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'PurchaseID' => 'required|exists:purchases,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PurchaseDate' => 'required|date',
        ]);

        PurchasePayment::create([
            'MethodID' => $validate['MethodID'],
            'PurchaseID' => $validate['PurchaseID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PurchaseDate' => $validate['PurchaseDate'],
        ]);

        return redirect()->route('purchasePayment.index')->with('success', 'Purchase Payment recorded successfully.');
    }

    public function edit(int $id)
    {
        $purchasePayment = PurchasePayment::findOrFail($id);
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $purchases = Purchase::all();
        return view('purchasePayment.edit', compact('purchasePayment', 'paymentMethods', 'purchases'));
    }

    public function update(Request $request, int $id)
    {
        $purchasePayment = PurchasePayment::findOrFail($id);

        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'PurchaseID' => 'required|exists:purchases,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PurchaseDate' => 'required|date',
        ]);

        $purchasePayment->update([
            'MethodID' => $validate['MethodID'],
            'PurchaseID' => $validate['PurchaseID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PurchaseDate' => $validate['PurchaseDate'],
        ]);

        return redirect()->route('purchasePayment.index')->with('success', 'Purchase Payment updated successfully.');
    }

    public function destroy(int $id)
    {
        $purchasePayment = PurchasePayment::findOrFail($id);
        $purchasePayment->delete();
        return redirect()->route('purchasePayment.index')->with('success', 'Purchase Payment deleted successfully.');
    }
}
