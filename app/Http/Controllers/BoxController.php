<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\ArchiveDemandDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $boxes=BoxArchiveRequest::all();
        $demands = ArchiveDemand::all();
        $demandsDetail = ArchiveDemandDetails::all();

        $lastDemand = ArchiveDemand::latest()->first();

        $lastDemand1 = ArchiveDemand::latest()->first()->id;
        $boxes = Box::where('archive_demand_id', $lastDemand1)->get();

        $numberOfBoxes = $boxes->count();


     



        return view('boxes.boxes', compact('demands', 'lastDemand', 'boxes', 'demandsDetail'));
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
        Box::create([
            'content' => $request->content,
            'ref' => $request->ref,
            // 'direction'=> $request->Direction,
            // 'department'=> $request->depart,
            'extreme_date' => $request->extreme_date,
            // 'destruction_date'=> $request->destruction_date,
            'archive_demand_id' => $request->archive_requests_id,
            'archive_demand_details_id' => $request->archieve_request_detail_id,


            // 'site_id' => $request->site_id,
        ]);

        // $id = ArchiveRequest::latest()->first()->id;
        session()->flash('Add', 'Box successfully added');
        // return redirect('/boxes');
        return back();
    }



    /**
     * Display the specified resource.
     */
    public function show(Box $boxArchiveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $boxes)
    {
            $id = $request->id;
            $boxes = Box::find($id);
            $boxes->update([
                'ref' => $request->ref,
                'content' => $request->content,
                'extreme_date' => $request->date,
            ]);
        
        session()->flash('edit', 'Box updated successfully');
        // return redirect('/boxes');
        return back();
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $boxes = Box::findOrFail($request->id);
        $boxes->delete();
        session()->flash('delete', 'The box has been successfully deleted');
        return back();
    }
}
