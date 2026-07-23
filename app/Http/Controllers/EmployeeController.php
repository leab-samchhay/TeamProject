<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Employee::paginate(10);
        return view('employee.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50|unique:employees,name',
            'sex'=> 'required|string|min:1|max:10',
            'phone'=> 'required|string|min:5|max:20',
            'email'=> 'required|string|min:2|max:20',
            'photo'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'=> 'required|string|min:2|max:100',
            'status'=> 'nullable|integer'
        ]);

        $path = null;
        if($request->hasFile('photo')){
            $path=$request->file('photo')->store('photo','public');
        }

        Employee::create([
            'name' => $validate['name'],
            'sex' => $validate['sex'],
            'phone' => $validate['phone'],
            'email' => $validate['email'],
            'photo' => $path,
            'role' => $validate['role'],
            'status' => $validate['active'] ?? 1 ,
        ]);

        return redirect()->route('employee.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $employee= Employee::findOrFail($id);
        return view('employee.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        $employee = Employee::findOrFail($id);

        $validate = $request->validate([
            'name'=> 'required|string|min:2|max:50',
            'sex'=> 'required|string|min:1|max:10',
            'phone'=> 'required|string|min:5|max:20',
            'email'=> 'required|string|min:2|max:20',
            'photo'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'=> 'required|string|min:2|max:100',
            'status' => 'nullable|integer',
        ]);

        $path = $employee->photo;

        if($request->hasFile('photo')){
            $path=$request->file('photo')->store('photo','public');
        }

        $employee->update([
            'name' => $validate['name'],
            'sex' => $validate['sex'],
            'phone' => $validate['phone'],
            'email' => $validate['email'],
            'photo' => $path,
            'role' => $validate['role'],
            'status' => $validate['status'] ?? 1,
        ]);

        return redirect()->route('employee.index')->with('success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $employee = Employee:: findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.index')->with('success');
    }
}
