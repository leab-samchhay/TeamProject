<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Exchange::with(['fromCurrency', 'toCurrency'])->paginate(10);
        return view('exchange.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::where('status', 1)->get();
        return view('exchange.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'rate' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'nullable|integer',
            'from_currency_id' => 'required|integer|exists:currencies,id|different:to_currency_id',
            'to_currency_id' => 'required|integer|exists:currencies,id',
        ]);

        Exchange::create([
            'rate' => $validate['rate'],
            'date' => $validate['date'],
            'status' => $validate['status'] ?? 1,
            'from_currency_id' => $validate['from_currency_id'],
            'to_currency_id' => $validate['to_currency_id'],
        ]);

        return redirect()->route('exchange.index')->with('success', 'Exchange created successfully.');
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
        $exchange = Exchange::findOrFail($id);
        $currencies = Currency::where('status', 1)->get();
        return view('exchange.edit', compact('exchange', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $exchange = Exchange::findOrFail($id);

        $validate = $request->validate([
            'rate' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'nullable|integer',
            'from_currency_id' => 'required|integer|exists:currencies,id|different:to_currency_id',
            'to_currency_id' => 'required|integer|exists:currencies,id',
        ]);

        $exchange->update([
            'rate' => $validate['rate'],
            'date' => $validate['date'],
            'status' => $validate['status'] ?? 1,
            'from_currency_id' => $validate['from_currency_id'],
            'to_currency_id' => $validate['to_currency_id'],
        ]);

        return redirect()->route('exchange.index')->with('success', 'Exchange updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $exchange = Exchange::findOrFail($id);
        $exchange->delete();
        return redirect()->route('exchange.index')->with('success', 'Exchange deleted successfully.');
    }
}
