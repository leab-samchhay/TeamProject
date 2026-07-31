<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Permission::paginate(10);
        return view('permission.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'permissionName'=> 'required|string|min:2|max:50|unique:permissions,permissionName',
            'permissionDate'=> 'required|date',
            'status'=> 'nullable|integer'
        ]);

        Permission::create([
            'permissionName' => $validate['permissionName'],
            'permissionDate' => $validate['permissionDate'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('permission.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $permission= Permission::findOrFail($id);
        return view('permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $permission = Permission::findOrFail($id);

        $validate = $request->validate([
            'permissionName'=> 'required|string|min:2|max:50',
            'permissionDate'=> 'required|date',
            'status'=> 'nullable|integer'
        ]);

        $permission->update([
            'permissionName' => $validate['permissionName'],
            'permissionDate' => $validate['permissionDate'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('permission.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $permission = Permission:: findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success');
    }
}
