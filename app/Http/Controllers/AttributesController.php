<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Attributes::with('values')->orderBy('display_order')->orderBy('name')->paginate(10);
        return view('attributes.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:attributes,name',
            'display_order' => 'nullable|integer|min:0',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Attribute name is required.',
        ]);

        $attribute = Attributes::create([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status == 'on' ? 1 : 0,
        ]);

        $this->syncValues($request, $attribute);

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attributes $attributes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $row = Attributes::with('values')->findOrFail($id);
        return view('attributes.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $row = Attributes::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100|unique:attributes,name,' . $row->id,
            'display_order' => 'nullable|integer|min:0',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Attribute name is required.',
        ]);

        $row->update([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status == 'on' ? 1 : 0,
        ]);

        $this->syncValues($request, $row);

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $row = Attributes::find($id);
        if ($row) {
            $row->delete(); // attribute_values cascade on delete
            return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
        }

        return redirect()->route('attributes.index')->with('error', 'Attribute could not be deleted.');
    }

    private function syncValues(Request $request, Attributes $attribute): void
    {
        $submitted = collect($request->input('values', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter()
            ->unique(fn ($v) => mb_strtolower($v))
            ->values();

        // Remove values no longer present.
        $attribute->values()->whereNotIn('value', $submitted)->delete();

        // Add new values, keeping submission order.
        $existing = $attribute->values()->pluck('value')->map(fn ($v) => mb_strtolower($v))->all();
        foreach ($submitted as $i => $value) {
            if (! in_array(mb_strtolower($value), $existing, true)) {
                $attribute->values()->create(['value' => $value, 'display_order' => $i]);
            }
        }
        
    }
}
