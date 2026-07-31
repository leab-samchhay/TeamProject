<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class PuchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Purchase::with(['supplier', 'user'])
            ->latest()
            ->paginate(10);

        return view('purchase.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 1)->get();
        $users     = User::where('status', 1)->get();

        return view('purchase.create', compact('suppliers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'buillno'     => 'required|string|max:255',
            'puchaseDate' => 'required|date',
            'discound'    => 'required|integer',
            'totalAmount' => 'required|numeric',
            'status'      => 'nullable|integer',
            'supplierId'  => 'required|exists:suppliers,id',
            'userId'      => 'required|exists:users,id',
        ]);

        Purchase::create($validate);

        return redirect()->route('purchase.index')->with('success', 'Purchase created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Puchase $puchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $purchase  = Purchase::findOrFail($id);
        $suppliers = Supplier::where('status', 1)->get();
        $users     = User::where('status', 1)->get();

        return view('purchase.edit', compact('purchase', 'suppliers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validate = $request->validate([
            'buillno'     => 'required|string|max:255',
            'puchaseDate' => 'required|date',
            'discound'    => 'required|numeric',
            'totalAmount' => 'required|numeric',
            'status'      => 'nullable|integer',
            'supplierId'  => 'required|exists:suppliers,id',
            'userId'      => 'required|exists:users,id',
        ]);

        $purchase->update($validate);

        return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return redirect()->route('purchase.index')->with('success', 'Purchase deleted successfully.');
    }
}
