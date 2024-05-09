<?php

namespace App\Http\Controllers;

use App\Models\boxArchiveRequest;
use App\Models\ArchiveRequest;
use App\Models\ArchieveRequestDetails;
use Illuminate\Http\Request;




class BoxArchiveRequestController extends Controller
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


        $boxes = BoxArchiveRequest::where('archive_request_id', $lastRequest1)->get();
        $numberOfBoxes = $boxes->count();

        
        
        return view('boxesArchiveRequest.boxesArchiveRequest',compact('demands','lastRequest','boxes','demandsDetail'));
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
        BoxArchiveRequest::create([
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
        return redirect('/boxesArchiveRequest');
    }



    /**
     * Display the specified resource.
     */
    public function show(boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $boxes = BoxArchiveRequest::findOrFail($request->id);
        $boxes->delete();
        session()->flash('delete', 'The box has been successfully deleted');
        return back();
    }



}




