<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use App\Models\Shelf;
use App\Models\BoxMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BoxArchivedController extends Controller
{
    public function index()
    {
        $acceptedDemands = ArchiveDemand::accepted()->pluck('id');

        $boxes = Box::whereIn('archive_demand_id', $acceptedDemands)->get();

        $sites = Site::all();
        $columns = Column::all();
        $rays = Ray::all();
        $shelves = Shelf::all();


        return view('boxes.boxes_archived', compact('boxes', 'sites', 'columns', 'rays', 'shelves'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $Id = $request->id;

        $boxes = Box::find($Id);

        $boxes->update([
            'shelf_id' => $request->input('shelf_id'),
            'location' => $request->input('location'),
        ]);
        session()->flash('edit', 'Location added successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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

        // Return the columns as JSON
        return json_encode($columns);
    }

    public function getShelves($id)
    {

        $shelves = DB::table("shelves")->where("column_id", $id)->pluck("name", "id");


        return json_encode($shelves);
    }
    public function borrow(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        // dd($box);
        $box->status = 'Not available';
        $box->request_number = $request->request_number;
        $box->transmission_date = $request->transmission_date;
        $box->return_date = $request->return_date;
        $box->save();


        return redirect()->back()->with('edit', 'Box status changed to Not available successfully');
    }

}
