<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites=Site::all();
        return view('sites.sites',compact('sites'));
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
            'name' => 'required|unique:sites|max:255',
            
        ],[
            'name.required' => 'Please enter the name of the site',
            'name.unique' => 'This site name already exists',
            
        ]);
                
            Site::create([
                'name' => $request->name,
               
               

            ]);
            session()->flash('Add', 'Site added successfully');
            return redirect('/sites');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $rayon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $rayon)
    {
       

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $sites)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:sites,name,'.$id,
            
        ],[

            'name.required' => 'Please enter the name of the site',
            'name.unique' => 'This site name already exists',

        ]);

        $sites = Site::find($id);
        $sites->update([
            'name' => $request->name,
            
        ]);

        session()->flash('edit','Modification successfully made');
        return redirect('/sites');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Site::find($id)->delete();
        session()->flash('delete','The site has been successfully deleted');
        return redirect('/sites');
    }
}
