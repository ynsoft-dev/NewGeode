<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\ArchiveRequest;
use App\Models\ArchieveRequestDetails;
use Illuminate\Http\Request;




class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $boxes=BoxArchiveRequest::all();
        $demands=ArchiveRequest::all();
        $demandsDetail=ArchieveRequestDetails::all();
        $lastRequest = ArchiveRequest::latest()->first();
        
        $lastRequest1 = ArchiveRequest::latest()->first()->id;


        $boxes = Box::where('archive_request_id', $lastRequest1)->get();
        $numberOfBoxes = $boxes->count();

        
        
        return view('boxes.boxes',compact('demands','lastRequest','boxes','demandsDetail'));
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
            'extreme_date'=> $request->extreme_date,
            // 'destruction_date'=> $request->destruction_date,
            'archive_request_id'=> $request->archive_requests_id,
            'archieve_request_details_id' =>$request->archieve_request_detail_id,
            
            
            // 'site_id' => $request->site_id,
        ]);
        session()->flash('Add', 'Box successfully added');
        return redirect('/boxes');
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
    public function edit(Box $boxArchiveRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $boxArchiveRequest)
    {
        $id = $request->id;

        $boxes = Box::find($id);
        $boxes->update([
            'ref' => $request->ref,
            'content' => $request->content,
            'extreme_date' => $request->date,
        ]);

        session()->flash('edit','Change made successfully');
        return redirect('/boxes');
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




