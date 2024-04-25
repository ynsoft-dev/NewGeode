<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites=Site::all();
        $columns=Column::all();
        $rays=Ray::all();
        $shelves=Shelf::all();
        return view('shelves.shelves',compact('sites','columns','rays','shelves'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Shelf $shelves)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shelf $shelves)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shelf $shelves)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shelf $shelves)
    {
        //
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
        // Fetch columns based on the received ray ID
        $columns = DB::table("columns")->where("ray_id", $id)->pluck("name", "id");

        dd($columns);
    
        // Return the columns as JSON
        return json_encode($columns);
    }
}
