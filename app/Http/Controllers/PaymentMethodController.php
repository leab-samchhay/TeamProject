<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $rows = PaymentMethod::paginate(10);
        return view('paymentMethod.index', compact('rows'));
    }

    public function create()
    {
        return view('paymentMethod.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'MethodName' => 'required|string|min:2|max:100|unique:payment_methods,MethodName',
            'Status' => 'nullable|integer'
        ]);

        PaymentMethod::create([
            'MethodName' => $validate['MethodName'],
            'Status' => $validate['Status'] ?? 1,
        ]);

        return redirect()->route('paymentMethod.index')->with('success', 'Payment Method created successfully.');
    }

    public function edit(int $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('paymentMethod.edit', compact('paymentMethod'));
    }

    public function update(Request $request, int $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $validate = $request->validate([
            'MethodName' => 'required|string|min:2|max:100|unique:payment_methods,MethodName,' . $id,
            'Status' => 'nullable|integer'
        ]);

        $paymentMethod->update([
            'MethodName' => $validate['MethodName'],
            'Status' => $validate['Status'] ?? 1,
        ]);

        return redirect()->route('paymentMethod.index')->with('success', 'Payment Method updated successfully.');
    }

    public function destroy(int $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();
        return redirect()->route('paymentMethod.index')->with('success', 'Payment Method deleted successfully.');
    }
}
