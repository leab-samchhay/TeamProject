<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Customer::paginate(10);
        return view('customer.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50|unique:customers,name',
            'sex'=> 'required|string|min:1|max:10',
            'phone'=> 'required|string|min:5|max:20',
            'status'=> 'nullable|integer'
        ]);

        Customer::create([
            'name' => $validate['name'],
            'sex' => $validate['sex'],
            'phone' => $validate['phone'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('customer.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $customer= Customer::findOrFail($id);
        return view('customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $customer = Customer::findOrFail($id);

        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50',
            'sex'=> 'required|string|min:1|max:10',
            'phone'=> 'required|string|min:5|max:20',
            'status'=> 'nullable|integer'
        ]);

        $customer->update([
            'name' => $validate['name'],
            'sex' => $validate['sex'],
            'phone' => $validate['phone'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('customer.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $customer = Customer:: findOrFail($id);
        $customer->delete();
        return redirect()->route('customer.index')->with('success');
    }
}
