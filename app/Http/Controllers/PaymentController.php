<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $rows = Payment::with(['paymentMethod', 'invoice'])->paginate(10);
        return view('payment.index', compact('rows'));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $invoices = Invoice::all();
        return view('payment.create', compact('paymentMethods', 'invoices'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'InvoiceID' => 'required|exists:invoices,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PaymentDate' => 'required|date',
        ]);

        Payment::create([
            'MethodID' => $validate['MethodID'],
            'InvoiceID' => $validate['InvoiceID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PaymentDate' => $validate['PaymentDate'],
        ]);

        return redirect()->route('payment.index')->with('success', 'Payment recorded successfully.');
    }

    public function edit(int $id)
    {
        $payment = Payment::findOrFail($id);
        $paymentMethods = PaymentMethod::where('Status', 1)->get();
        $invoices = Invoice::all();
        return view('payment.edit', compact('payment', 'paymentMethods', 'invoices'));
    }

    public function update(Request $request, int $id)
    {
        $payment = Payment::findOrFail($id);

        $validate = $request->validate([
            'MethodID' => 'required|exists:payment_methods,id',
            'InvoiceID' => 'required|exists:invoices,id',
            'TotalPayment' => 'required|numeric|min:0',
            'PaymentDate' => 'required|date',
        ]);

        $payment->update([
            'MethodID' => $validate['MethodID'],
            'InvoiceID' => $validate['InvoiceID'],
            'TotalPayment' => $validate['TotalPayment'],
            'PaymentDate' => $validate['PaymentDate'],
        ]);

        return redirect()->route('payment.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(int $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully.');
    }
}
