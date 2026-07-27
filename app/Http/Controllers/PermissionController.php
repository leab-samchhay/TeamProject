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
        return view('permision.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permision.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'permistionName'=> 'required|string|min:2|max:50|unique:permissions,permistionName',
            'permistionDate'=> 'required|date',
            'status'=> 'nullable|integer'
        ]);

        Permission::create([
            'permistionName' => $validate['permistionName'],
            'permistionDate' => $validate['permistionDate'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('permision.index')->with('success');
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
        $permision= Permission::findOrFail($id);
        return view('permision.edit',compact('permision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $permistion = Permission::findOrFail($id);

        $validate = $request->validate([
            'permistionName'=> 'required|string|min:2|max:50',
            'permistionDate'=> 'required|date',
            'status'=> 'nullable|integer'
        ]);

        $permistion->update([
            'permistionName' => $validate['permistionName'],
            'permistionDate' => $validate['permistionDate'],
            'status' => $validate['status'] ?? 1 ,
        ]);

        return redirect()->route('permision.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $permision = Permission:: findOrFail($id);
        $permision->delete();
        return redirect()->route('permision.index')->with('success');
    }
}
