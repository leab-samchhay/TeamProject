<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Product::with(['category', 'supplier'])->paginate(10);
        return view('product.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();
        return view('product.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'ProName'     => 'required|string|min:2|max:200',
            'ProNameKh'   => 'nullable|string|max:200',
            'Barcode'     => 'nullable|string|max:100|unique:products,Barcode',
            'Qty_Onhand'  => 'nullable|integer|min:0',
            'Qty_Alert'   => 'nullable|integer|min:0',
            'Remark'      => 'nullable|string|max:200',
            'Photo'       => 'nullable|image|max:2048',
            'StockType'   => 'nullable|string|max:200',
            'Status'      => 'nullable|integer',
            'CategoryID'  => 'required|exists:categories,id',
            'SupplierID'  => 'required|exists:suppliers,id',
        ]);

        if ($request->hasFile('Photo')) {
            $validate['Photo'] = $request->file('Photo')->store('products', 'public');
        }

        Product::create([
            'ProName'    => $validate['ProName'],
            'ProNameKh'  => $validate['ProNameKh'] ?? null,
            'Barcode'    => $validate['Barcode'] ?? null,
            'Qty_Onhand' => $validate['Qty_Onhand'] ?? 0,
            'Qty_Alert'  => $validate['Qty_Alert'] ?? 0,
            'Remark'     => $validate['Remark'] ?? null,
            'Photo'      => $validate['Photo'] ?? null,
            'StockType'  => $validate['StockType'] ?? null,
            'Status'     => $validate['Status'] ?? 1,
            'CategoryID' => $validate['CategoryID'],
            'SupplierID' => $validate['SupplierID'],
        ]);

        return redirect()->route('product.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();
        return view('product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validate = $request->validate([
            'ProName'     => 'required|string|min:2|max:200',
            'ProNameKh'   => 'nullable|string|max:200',
            'Barcode'     => 'nullable|string|max:100|unique:products,Barcode,' . $id . ',id',
            'Qty_Onhand'  => 'nullable|integer|min:0',
            'Qty_Alert'   => 'nullable|integer|min:0',
            'Remark'      => 'nullable|string|max:200',
            'Photo'       => 'nullable|image|max:2048',
            'StockType'   => 'nullable|string|max:200',
            'Status'      => 'nullable|integer',
            'CategoryID'  => 'required|exists:categories,id',
            'SupplierID'  => 'required|exists:suppliers,id',
        ]);

        if ($request->hasFile('Photo')) {
            $validate['Photo'] = $request->file('Photo')->store('products', 'public');
        } else {
            unset($validate['Photo']); // រក្សារូបភាពចាស់ បើគ្មានផ្ទុកថ្មី
        }

        $product->update([
            'ProName'    => $validate['ProName'],
            'ProNameKh'  => $validate['ProNameKh'] ?? null,
            'Barcode'    => $validate['Barcode'] ?? null,
            'Qty_Onhand' => $validate['Qty_Onhand'] ?? 0,
            'Qty_Alert'  => $validate['Qty_Alert'] ?? 0,
            'Remark'     => $validate['Remark'] ?? null,
            'Photo'      => $validate['Photo'] ?? $product->Photo,
            'StockType'  => $validate['StockType'] ?? null,
            'Status'     => $validate['Status'] ?? 1,
            'CategoryID' => $validate['CategoryID'],
            'SupplierID' => $validate['SupplierID'],
        ]);

        return redirect()->route('product.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success');
    }
}
