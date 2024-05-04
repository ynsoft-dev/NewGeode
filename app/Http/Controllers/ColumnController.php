<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    if (!Gate::allows('columns')) {
        abort(403, 'Unauthorized action.');
    }
        $sites=Site::all();
        $columns=Column::all();
        $rays=Ray::all();
        return view('columns.columns',compact('sites','columns','rays'));
      
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
        Column::create([
            'name' => $request->name,
            
            
            'site_id' => $request->Site,
            'ray_id' => $request->ray,
            // 'site_id' => $request->site_id,
        ]);
        session()->flash('Add', 'Column successfully added');
        return redirect('/columns');
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
        // $id = Site::where('name', $request->site_name)->first()->id;
        // $id1 = Ray::where('name', $request->ray_name)->first()->id;

        // $Columns = Column::findOrFail($request->id);

        // $Columns->update([
        //     'name' => $request->name,
        //     'site_id' => $id,
        //     'ray_id' => $id1,
        // ]);

        // session()->flash('edit', 'The modifications to the ray have been successfully applied');
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Columns = Column::findOrFail($request->id);
        $Columns->delete();
        session()->flash('delete', 'The column has been successfully deleted');
        return back();
    }

    public function getRays($id)
    {
      
    
        // Fetch rays based on the received site ID
        $rays = DB::table("rays")->where("site_id", $id)->pluck("name", "id");
    
    
        // Return the rays as JSON
        return json_encode($rays);
    }


    public function getColumns($id)
    {
      
    
        // Fetch rays based on the received site ID
        $columns = DB::table("columns")->where("site_id", $id)->pluck("name", "id");
    
    
        // Return the rays as JSON
        return json_encode($columns);
    }
    
}