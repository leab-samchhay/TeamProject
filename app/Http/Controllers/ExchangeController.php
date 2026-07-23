<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Exchange::paginate(10);
        return view('exchange.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exchange.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'rate' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'nullable|integer'
        ]);

        Exchange::create([
            'rate' => $validate['rate'],
            'date' => $validate['date'],
            'status' => $validate['status'] ?? 1,
        ]);

        return redirect()->route('exchange.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $exchange= Exchange::findOrFail($id);
        return view('exchange.edit',compact('exchange'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        $exchange = Exchange::findOrFail($id);
        $validate = $request->validate([
            'rate' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'nullable|integer'
        ]);

        $exchange->update([
            'rate' => $validate['rate'],
            'date' => $validate['date'],
            'status' => $validate['status'] ?? 1,
        ]);

        return redirect()->route('exchange.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $exchange = Exchange:: findOrFail($id);
        $exchange->delete();
        return redirect()->route('exchange.index')->with('success');
    }
}
