<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Role::paginate(10);
        return view('role.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=>'required|string|min:2|max:50|unique:roles,name',
            'description'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'

        ]);

        Role::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'status' => $validate['status'] ?? 1 ,
        ]);
        return redirect()->route('role.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $role= Role::findOrFail($id);
        return view('role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $role = Role::findOrFail($id);

        $validate = $request->validate([
            'name'=>'required|string|min:2|max:50',
            'description'=>'required|string|min:2|max:255',
            'status'=> 'nullable|integer'
        ]);

        $role->update([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('role.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $role = Role:: findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success');
    }
}
