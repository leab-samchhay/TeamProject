<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Variants;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product_Variants::with('product');

        if ($request->filled('search')) {
            $query->where('sku', 'like', '%' . $request->search . '%')
                ->orWhere('barcode', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $rows = $query->paginate(10);
        $products = Product::where('status', 1)->get();

        return view('product_variants.index', compact('rows', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('product_variants.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'       => 'required|exists:products,id',
            'sku'              => 'nullable|string|max:100|unique:product__variants,sku',
            'barcode'          => 'nullable|string|max:100|unique:product__variants,barcode',
            'qr_code'          => 'nullable|string|max:100',
            'cost'             => 'nullable|numeric|min:0',
            'selling_price'    => 'nullable|numeric|min:0',
            'wholesale_price'  => 'nullable|numeric|min:0',
            'minimum_stock'    => 'nullable|integer|min:0',
            'current_stock'    => 'nullable|integer|min:0',
            'weight'           => 'nullable|numeric|min:0',
            'image'            => 'nullable|image|max:2048',
            'status'           => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product-variants', 'public');
        }

        $validated['status'] = $request->has('status') ? true : false;

        Product_Variants::create($validated);

        return redirect()->route('product-variants.index')->with('success', 'Product variant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $variant = Product_Variants::with('product')->findOrFail($id);
        return view('product_variants.show', compact('variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $variant = Product_Variants::findOrFail($id);
        $products = Product::where('status', 1)->get();
        return view('product_variants.edit', compact('variant', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $variant = Product_Variants::findOrFail($id);

        $validated = $request->validate([
            'product_id'       => 'required|exists:products,id',
            'sku'              => 'nullable|string|max:100|unique:product__variants,sku,' . $id,
            'barcode'          => 'nullable|string|max:100|unique:product__variants,barcode,' . $id,
            'qr_code'          => 'nullable|string|max:100',
            'cost'             => 'nullable|numeric|min:0',
            'selling_price'    => 'nullable|numeric|min:0',
            'wholesale_price'  => 'nullable|numeric|min:0',
            'minimum_stock'    => 'nullable|integer|min:0',
            'current_stock'    => 'nullable|integer|min:0',
            'weight'           => 'nullable|numeric|min:0',
            'image'            => 'nullable|image|max:2048',
            'status'           => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($variant->image) {
                \Storage::disk('public')->delete($variant->image);
            }
            $validated['image'] = $request->file('image')->store('product-variants', 'public');
        }

        $validated['status'] = $request->has('status') ? true : false;

        $variant->update($validated);

        return redirect()->route('product-variants.index')->with('success', 'Product variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = Product_Variants::findOrFail($id);

        if ($variant->image) {
            \Storage::disk('public')->delete($variant->image);
        }

        $variant->delete();

        return redirect()->route('product-variants.index')->with('success', 'Product variant deleted successfully.');
    }
}
