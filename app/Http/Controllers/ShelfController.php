<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use Illuminate\Support\Facades\Gate;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { // Vérifiez si l'utilisateur a la permission 'show_permission'
        if (!Gate::allows('shelves')) {
            abort(403, 'Unauthorized action.');
        }
        $sites = Site::all();
        $columns = Column::all();
        $rays = Ray::all();
        $shelves = Shelf::all();
        return view('shelves.shelves', compact('sites', 'columns', 'rays', 'shelves'));
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
        Shelf::create([
            'name' => $request->name,
            'site_id' => $request->Site,
            'ray_id' => $request->ray,
            'column_id' => $request->column,
            // 'site_id' => $request->site_id,
        ]);
        session()->flash('Add', 'Shelf successfully added');
        return redirect('/shelves');
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
    public function destroy(Request $request)
    {
        $Shelves = Shelf::findOrFail($request->id);
        $Shelves->delete();
        session()->flash('delete', 'The shelf has been successfully deleted');
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
        // Fetch columns based on the received ray ID
        $columns = DB::table("columns")->where("ray_id", $id)->pluck("name", "id");



        // Return the columns as JSON
        return json_encode($columns);

        // dd($columns);
    }
}