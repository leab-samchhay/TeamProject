<?php

namespace App\Http\Controllers;

use App\Models\PuchasePayment;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PuchasePaymentController extends Controller
{
    public function index()
    {
        $rows = PuchasePayment::with(['paymentMethod', 'purchase'])->paginate(10);
        return view('puchasePayment.index', compact('rows'));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $purchases = Purchase::all();
        return view('puchasePayment.create', compact('paymentMethods', 'purchases'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'PuchaseID' => 'required|exists:puchases,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PuchaseDate' => 'required|date',
        ]);

        PuchasePayment::create([
            'MethodID' => $validate['MethodID'],
            'PuchaseID' => $validate['PuchaseID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PuchaseDate' => $validate['PuchaseDate'],
        ]);

        return redirect()->route('puchasePayment.index')->with('success', 'Purchase Payment recorded successfully.');
    }

    public function edit(int $id)
    {
        $puchasePayment = PuchasePayment::findOrFail($id);
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $purchases = Purchase::all();
        return view('puchasePayment.edit', compact('puchasePayment', 'paymentMethods', 'purchases'));
    }

    public function update(Request $request, int $id)
    {
        $puchasePayment = PuchasePayment::findOrFail($id);

        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'PuchaseID' => 'required|exists:puchases,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PuchaseDate' => 'required|date',
        ]);

        $puchasePayment->update([
            'MethodID' => $validate['MethodID'],
            'PuchaseID' => $validate['PuchaseID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PuchaseDate' => $validate['PuchaseDate'],
        ]);

        return redirect()->route('puchasePayment.index')->with('success', 'Purchase Payment updated successfully.');
    }

    public function destroy(int $id)
    {
        $puchasePayment = PuchasePayment::findOrFail($id);
        $puchasePayment->delete();
        return redirect()->route('puchasePayment.index')->with('success', 'Purchase Payment deleted successfully.');
    }
}
