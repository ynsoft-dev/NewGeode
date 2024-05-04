<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Ray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('rays')) {
            abort(403, 'Unauthorized action.');
        }
        $sites = Site::all();
        $rays = Ray::all();
        return view('rays.rays', compact('rays', 'sites'));
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
        Ray::create([
            'name' => $request->name,
            'site_id' => $request->site_id,
        ]);
        session()->flash('Add', 'Ray successfully added');
        return redirect('/rays');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ray $ray)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ray $ray)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ray $rays)
    {
        $id = Site::where('name', $request->site_name)->first()->id;

        $Rays = Ray::findOrFail($request->id);

        $Rays->update([
            'name' => $request->name,
            'site_id' => $id,
        ]);

        session()->flash('edit', 'The modifications to the ray have been successfully applied');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Rays = Ray::findOrFail($request->id);
        $Rays->delete();
        session()->flash('delete', 'The ray has been successfully deleted');
        return back();
    }
}