<?php

// namespace App\Http\Controllers;

// use App\Models\Customer;
// use App\Models\Exchange;
// use App\Models\Invoice;
// use App\Models\User;
// use Illuminate\Http\Request;

// class InvoiceController extends Controller
// {
//     public function index()
//     {
//         $rows = Invoice::with(['customer', 'user', 'exchange.fromCurrency', 'exchange.toCurrency'])
//             ->latest()
//             ->paginate(10);

//         return view('invoice.index', compact('rows'));
//     }

//     public function create()
//     {
//         $customers = Customer::where('status', 1)->get();
//         $users     = User::where('status', 1)->get();
//         $exchanges = Exchange::with(['fromCurrency', 'toCurrency'])
//             ->where('status', 1)
//             ->get();

//         return view('invoice.create', compact('customers', 'users', 'exchanges'));
//     }

//     public function store(Request $request)
//     {
//         $validate = $request->validate([
//             'invoiceDate' => 'required|date',
//             'discound'    => 'required|integer',
//             'total'       => 'required|numeric',
//             'status'      => 'nullable|integer',
//             'CustomerID'  => 'required|exists:customers,id',
//             'UserID'      => 'required|exists:users,id',
//             'ExchangeID'  => 'required|exists:exchanges,id',
//         ]);

//         Invoice::create($validate);

//         return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
//     }

//     public function show(Invoice $invoice)
//     {
//         //
//     }

//     public function edit(int $id)
//     {
//         $invoice   = Invoice::findOrFail($id);
//         $customers = Customer::where('status', 1)->get();
//         $users     = User::where('status', 1)->get();
//         $exchanges = Exchange::with(['fromCurrency', 'toCurrency'])
//             ->where('status', 1)
//             ->get();

//         return view('invoice.edit', compact('invoice', 'customers', 'users', 'exchanges'));
//     }

//     public function update(Request $request, int $id)
//     {
//         $invoice = Invoice::findOrFail($id);

//         $validate = $request->validate([
//             'invoiceDate' => 'required|date',
//             'discound'    => 'required|integer',
//             'total'       => 'required|numeric',
//             'status'      => 'nullable|integer',
//             'CustomerID'  => 'required|exists:customers,id',
//             'UserID'      => 'required|exists:users,id',
//             'ExchangeID'  => 'required|exists:exchanges,id',
//         ]);

//         $invoice->update($validate);

//         return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
//     }

//     public function destroy(int $id)
//     {
//         $invoice = Invoice::findOrFail($id);
//         $invoice->delete();

//         return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Exchange;
use Illuminate\Support\Facades\DB;
use Exception;

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
        // 1. Validation ពិនិត្យមើលទិន្នន័យដែលផ្ញើមកឱ្យបានត្រឹមត្រូវ
        $request->validate([
            'CustomerID'         => 'required|exists:customers,id',
            'UserID'             => 'required|exists:users,id',
            'ExchangeID'         => 'required|exists:exchanges,id',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric',
        ], [
            'items.required'      => 'សូមជ្រើសរើសទំនិញចូល Cart ជាមុនសិន!',
            'CustomerID.required' => 'សូមជ្រើសរើសអតិថិជន!',
            'UserID.required'     => 'សូមជ្រើសរើសអ្នកគិតលុយ!',
            'ExchangeID.required' => 'សូមជ្រើសរើសអត្រាប្តូរប្រាក់ (Exchange)!'
        ]);

        DB::beginTransaction();

        try {
            // 2. គណនាសរុបទឹកប្រាក់ (Total Amount)
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // យក ExchangeID ដែលមានស្រាប់ក្នុង DB ប្រសិនបើ Form មិនបានផ្ញើមក
            // $exchangeId = $request->ExchangeID ?? Exchange::value('id') ?? 1;

            // 3. រក្សាទុកក្នុង Table `invoices`
            $invoice = Invoice::create([
                'CustomerID'  => $request->CustomerID,
                'UserID'      => $request->UserID,
                'ExchangeID'  => $request->ExchangeID,
                'total'       => $totalAmount,
                'invoiceDate' => now(),
                'discount'    => 0,
                'status'      => 1,
            ]);

            // 4. រក្សាទុកក្នុង Table `invoice_details`
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                // ពិនិត្យមើលថាតើស្តុកមានគ្រប់គ្រាន់សម្រាប់លក់ដែរឬទេ
                if ($product && $product->Qty_Onhand < $item['quantity']) {
                    throw new Exception("ទំនិញ '" . ($product->ProNameKh ?? $product->ProName) . "' មិនមានស្តុកគ្រប់គ្រាន់ទេ! (នៅសល់ក្នុងស្តុក: " . $product->Qty_Onhand . ")");
                }

                $subtotal = $item['price'] * $item['quantity'];

                InvoiceDetail::create([
                    'InvoiceID' => $invoice->id,
                    'ProductID' => $item['product_id'],
                    'qty'       => $item['quantity'],
                    'price'     => $item['price'],
                    'cost'      => $product->cost ?? 0,
                    'totalPay'  => $subtotal,
                    'discount'  => $item['discount'] ?? 0,
                ]);

                // ដកចំនួនស្តុកចេញពី Column Qty_Onhand
                if ($product && isset($product->Qty_Onhand)) {
                    $product->decrement('Qty_Onhand', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('sale.index')->with('success', 'រក្សាទុកការលក់ (Invoice) បានជោគជ័យ!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ៖ ' . $e->getMessage());
        }
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
            'discount'    => 'required|integer',
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
