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
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Auth;
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
            'discount'           => 'nullable|numeric|min:0',
            'ExchangeID'         => 'required|exists:exchanges,id',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric',
        ], [
            'items.required'      => 'សូមជ្រើសរើសទំនិញចូល Cart ជាមុនសិន!',
            'ExchangeID.required' => 'សូមជ្រើសរើសអត្រាប្តូរប្រាក់ (Exchange)!'
        ]);

        DB::beginTransaction();

        try {
            $discount    = max(0, floatval($request->discount ?? 0));
            $subtotal    = 0;
            $userId      = Auth::id();
            $exchangeId  = $request->ExchangeID;

            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $totalAmount = max(0, $subtotal - $discount);

            $customer = Customer::create([
                'name'   => 'general',
                'sex'    => 'N/A',
                'phone'  => null,
                'status' => 1,
            ]);

            $invoice = Invoice::create([
                'CustomerID'  => $customer->id,
                'UserID'      => $userId,
                'ExchangeID'  => $exchangeId,
                'total'       => $totalAmount,
                'invoiceDate' => now(),
                'discount'    => $discount,
                'status'      => 1,
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    throw new Exception('Product not found.');
                }

                if ($product->Qty_Onhand < $item['quantity']) {
                    throw new Exception("ទំនិញ '" . ($product->ProNameKh ?? $product->ProName) . "' មិនមានស្តុកគ្រប់គ្រាន់ទេ! (នៅសល់ក្នុងស្តុក: " . $product->Qty_Onhand . ")");
                }

                $purchaseCost = PurchaseDetail::where('productID', $product->id)
                    ->orderByDesc('created_at')
                    ->value('cost') ?? 0;

                $subtotalItem = $item['price'] * $item['quantity'];

                InvoiceDetail::create([
                    'InvoiceID' => $invoice->id,
                    'ProductID' => $product->id,
                    'qty'       => $item['quantity'],
                    'price'     => $item['price'],
                    'cost'      => $purchaseCost,
                    'totalPay'  => $subtotalItem,
                    'discount'  => 0,
                ]);

                $product->decrement('Qty_Onhand', $item['quantity']);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                $exchange = Exchange::find($exchangeId);
                $rate = $exchange->rate ?? null;

                return response()->json([
                    'success' => true,
                    'invoice_id' => $invoice->id,
                    'subtotal' => round($subtotal, 2),
                    'discount' => round($discount, 2),
                    'total' => round($totalAmount, 2),
                    'exchange_rate' => $rate,
                ]);
            }

            return redirect()->route('sale.index')->with('success', 'រក្សាទុកការលក់ (Invoice) បានជោគជ័យ!');
        } catch (Exception $e) {
            DB::rollBack();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'មានបញ្ហាក្នុងការរក្សាទិន្នន័យ៖ ' . $e->getMessage());
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
