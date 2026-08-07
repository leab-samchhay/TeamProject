<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Variants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Product_Variants ::with('product')->latest()->paginate(10);
        return view('product_variants.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', 1)->orderBy('name')->get();
        return view('product_variants.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'nullable|max:100|unique:product_variants,sku',
            'barcode' => 'nullable|max:100|unique:product_variants,barcode',
            'qr_code' => 'nullable|max:100',
            'cost' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'product_id.required' => 'Please choose a product.',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_variants', 'public');
        }

        Product_Variants::create([
            'product_id' => $request->product_id,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'qr_code' => $request->qr_code,
            'cost' => $request->cost ?? 0,
            'selling_price' => $request->selling_price ?? 0,
            'wholesale_price' => $request->wholesale_price ?? 0,
            'minimum_stock' => $request->minimum_stock ?? 0,
            'current_stock' => $request->current_stock ?? 0,
            'weight' => $request->weight,
            'image' => $path,
            'status' => $request->status == 'on' ? 1 : 0,
        ]);

        return redirect()->route('product-variants.index')->with('success', 'Variant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Product_Variants::findOrFail($id);
        $products = Product::where('status', 1)->orderBy('name')->get();
        return view('product_variants.edit', compact('row', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $row = Product_Variants::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'nullable|max:100|unique:product_variants,sku,' . $row->id,
            'barcode' => 'nullable|max:100|unique:product_variants,barcode,' . $row->id,
            'qr_code' => 'nullable|max:100',
            'cost' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'product_id.required' => 'Please choose a product.',
        ]);

        if ($request->hasFile('image')) {
            if ($row->image && Storage::disk('public')->exists($row->image)) {
                Storage::disk('public')->delete($row->image);
            }
            $row->image = $request->file('image')->store('product_variants', 'public');
        }

        $row->product_id = $request->product_id;
        $row->sku = $request->sku;
        $row->barcode = $request->barcode;
        $row->qr_code = $request->qr_code;
        $row->cost = $request->cost ?? 0;
        $row->selling_price = $request->selling_price ?? 0;
        $row->wholesale_price = $request->wholesale_price ?? 0;
        $row->minimum_stock = $request->minimum_stock ?? 0;
        $row->current_stock = $request->current_stock ?? 0;
        $row->weight = $request->weight;
        $row->status = $request->status == 'on' ? 1 : 0;
        $row->save();

        return redirect()->route('product-variants.index')->with('success', 'Variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = Product_Variants::find($id);
        if ($row) {
            if ($row->image && Storage::disk('public')->exists($row->image)) {
                Storage::disk('public')->delete($row->image);
            }
            $row->delete();
            return redirect()->route('product-variants.index')->with('success', 'Variant deleted successfully.');
        }

        return redirect()->route('product-variants.index')->with('error', 'Variant could not be deleted.');
    }
}
