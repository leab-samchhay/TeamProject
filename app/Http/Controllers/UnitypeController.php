<?php

namespace App\Http\Controllers;

use App\Models\Unitype;
use Illuminate\Http\Request;

class UnitypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Unitype::paginate(10);
        return view('unitype.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unitype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=>'required|string|min:2|max:50|unique:roles,name',
            'qty'=>'required|integer',
            'status'=> 'nullable|integer'

        ]);

        Unitype::create([
            'name' => $validate['name'],
            'qty' => $validate['qty'],
            'status' => $validate['status'] ?? 1 ,
        ]);
        return redirect()->route('unitype.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unitype $unitype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $unitype= Unitype::findOrFail($id);
        return view('unitype.edit',compact('unitype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $unitype = unitype::findOrFail($id);

        $validate = $request->validate([
            'name'=>'required|string|min:2|max:50',
            'qty'=>'required|integer',
            'status'=> 'nullable|integer'
        ]);

        $unitype->update([
            'name' => $validate['name'],
            'qty' => $validate['qty'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('unitype.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $unitype = Unitype:: findOrFail($id);
        $unitype->delete();
        return redirect()->route('unitype.index')->with('success');
    }
}
