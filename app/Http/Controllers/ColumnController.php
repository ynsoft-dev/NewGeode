<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites=Site::all();
        $columns=Column::all();
        return view('columns.columns',compact('sites','columns'));
      
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $sites=Site::all();
        // return view('columns.columns',compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Column::create([
        //     'name' => $request->name,
        //     'ray_id' => $request->ray_id,
        //     // 'site_id' => $request->site_id,
        // ]);
        // session()->flash('Add', 'Column successfully added');
        // return redirect('/etageres');
    }

    /**
     * Display the specified resource.
     */
    public function show(Column $columns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Column $columns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Column $columns)
    {
        // $id = Ray::where('name', $request->ray_name)->first()->id;

        // $Columns = Column::findOrFail($request->id);
    
        // $Columns->update([
        // 'name' => $request->name,
        // 'ray_id' => $id,
        // ]);
    
        // session()->flash('edit', 'The modifications to the column have been successfully applied');
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request)
    {
        // $Columns = Column::findOrFail($request->id);
        // $Columns->delete();
        // session()->flash('delete', 'The column has been successfully deleted');
        // return back();
    }

    public function getrays($id)
    {
        // Log the received ID
        error_log('Received ID: ' . $id);
    
        // Fetch rays based on the received site ID
        $rays = DB::table("rays")->where("site_id", $id)->pluck("name", "id");
    
        // Log the retrieved rays
        error_log('Retrieved rays: ' . json_encode($rays));
    
        // Return the rays as JSON
        return json_encode($rays);
    }
    
}
