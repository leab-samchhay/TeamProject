<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Supplier::paginate(10);
        return view('supplier.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50|unique:suppliers,name',
            'phone'=> 'required|string|min:1|max:10',
            'email'=> 'required|string|min:2|max:50',
            'address'=> 'required|string|min:2|max:255',
            'status'=> 'nullable|integer'
        ]);

        Supplier::create([
            'name' => $validate['name'],
            'phone' => $validate['phone'],
            'email' => $validate['email'],
            'address' => $validate['address'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('supplier.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $supplier= Supplier::findOrFail($id);
        return view('supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50',
            'phone'=> 'required|string|min:1|max:10',
            'email'=> 'required|string|min:2|max:50',
            'address'=> 'required|string|min:2|max:255',
            'status'=> 'nullable|integer'
        ]);

        $supplier->update([
            'name' => $validate['name'],
            'phone' => $validate['phone'],
            'email' => $validate['email'],
            'address' => $validate['address'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('supplier.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $supplier = Supplier:: findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success');
    }
}
