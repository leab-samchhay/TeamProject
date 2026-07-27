<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = User::with(['permission', 'role'])->paginate(10);
        return view('user.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::where('status', 1)->get();
        $roles = Role::where('status', 1)->get();
        return view('user.create', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'     => 'required|string|min:2|max:50',
            'email'   => 'nullable|string|max:50',
            'password'     => 'nullable|string|min:6',
            'permission_id'  => 'required|exists:permissions,id',
            'role_id'   => 'required|nullable|exists:roles,id',
            'expired'      => 'nullable|date',
            'Status'      => 'nullable|integer',

        ]);

        User::create([
            'name'    => $validate['name'],
            'email'  => $validate['email'] ?? null,
            'password' => Hash::make($validate['password']),
            'permission_id' => $validate['permission_id'],
            'role_id'  => $validate['role_id'] ,
            'expired'     => $validate['expired'],
            'Status'     => $validate['Status'] ?? 1,
        ]);

        return redirect()->route('user.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::where('status', 1)->get();
        $roles = Role::where('status', 1)->get();
        return view('user.edit', compact('permissions','roles','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validate = $request->validate([
            'name'           => 'required|string|min:2|max:50',
            'email'          => 'nullable|string|max:50',
            'password'       => 'nullable|string|min:6',
            'permission_id'  => 'required|exists:permissions,id',
            'role_id'        => 'required|exists:roles,id',
            'expired'        => 'nullable|date',
            'Status'         => 'nullable|integer',
        ]);

        $user->update([
            'name'           => $validate['name'],
            'email'          => $validate['email'] ?? null,
            'password'       => !empty($validate['password']) ? Hash::make($validate['password']) : $user->password,
            'permission_id'  => $validate['permission_id'],
            'role_id'        => $validate['role_id'],
            'expired'        => $validate['expired'],
            'status'         => $validate['Status'] ?? 1, // match $fillable casing
        ]);

        return redirect()->route('user.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success');
    }
}
