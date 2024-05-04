<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   if (!Gate::allows('departments')) {
        abort(403, 'Unauthorized action.');
    }
        $directions=Direction::all();
        $departments=Department::all();
        // dd($directions);
        return view('departments.departments',compact('directions','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Department::create([

            'name' => $request->name,
            'directions_id' => $request->directions_id,
        ]);
        session()->flash('Add', 'Department added sucessfully');
        return redirect('/departments');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $departments)
    {
            $id = Direction::where('name', $request->direction_name)->first()->id;

            $Departments = Department::findOrFail($request->id);
    
            $Departments->update([
            'name' => $request->name,
            'directions_id' => $id,
            ]);
    
            session()->flash('Edit', 'Department changes made successfully');
            return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Departments = Department::findOrFail($request->id);
        $Departments->delete();
        session()->flash('delete', 'The department has been successfully deleted');
        return back();
    }
}