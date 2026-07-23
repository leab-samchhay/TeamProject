<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Category::paginate(10);
        return view('category.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50|unique:categories,name',
            'description'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'
        ]);

        Category::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('category.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $category= Category::findOrFail($id);
        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        $category = Category::findOrFail($id);

        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50',
            'description'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'
        ]);

        $category->update([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('category.index')->with('success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = Category:: findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success');
    }
}
