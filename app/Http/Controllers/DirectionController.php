<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { if (!Gate::allows('directions')) {
        abort(403, 'Unauthorized action.');
    }
        $directions=Direction::all();
        return view('directions.directions',compact('directions'));
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
        $validated = $request->validate([
            'name' => 'required|unique:directions|max:255',
            // 'description' => 'required',
        ],[
            'name.required' => 'Please enter the name of the direction',
            'name.unique' => 'This direction name already exists',
            // 'description.required' => 'Please enter description',
        ]);
                
            Direction::create([
                'name' => $request->name,
                'description' => $request->description,
               

            ]);
            session()->flash('Add', 'Direction added successfully');
            return redirect('/directions');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Direction $directions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Direction $directions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Direction $directions)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:directions,name,'.$id,
            'description' => 'required',
        ],[

            'name.required' =>'Please enter the name of the direction',
            'name.unique' =>'This direction name already exists',
            'description.required' =>'Please enter description',

        ]);

        $directions = Direction::find($id);
        $directions->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        session()->flash('edit','Change made successfully');
        return redirect('/directions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Direction::find($id)->delete();
        session()->flash('delete','Direction has been successfully removed');
        return redirect('/directions');
    }
}