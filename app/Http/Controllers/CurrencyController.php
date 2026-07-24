<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Currency::paginate(10);
        return view('currency.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'currencycode'=>'required|string|min:2|max:50',
            'namecurrency'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'

        ]);

        Currency::create([
            'currencycode' => $validate['currencycode'],
            'namecurrency' => $validate['namecurrency'],
            'status' => $validate['status'] ?? 1 ,
        ]);
        return redirect()->route('currency.index')->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $currency= Currency::findOrFail($id);
        return view('currency.edit',compact('currency'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $currency = Currency::findOrFail($id);

        $validate = $request->validate([
            'currencycode'=>'required|string|min:2|max:50',
            'namecurrency'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'

        ]);

        $currency->update([
            'currencycode' => $validate['currencycode'],
            'namecurrency' => $validate['namecurrency'],
            'status' => $validate['status'] ?? 1 ,
        ]);
        return redirect()->route('currency.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $currency = Currency:: findOrFail($id);
        $currency->delete();
        return redirect()->route('currency.index')->with('success');
    }
}
