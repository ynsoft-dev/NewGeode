<?php

namespace App\Http\Controllers;

use App\Models\ArchieveRequestDetails;
use App\Models\ArchiveRequest;

use Illuminate\Http\Request;

class ArchieveRequestDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   
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
    public function show(ArchieveRequestDetails $ArchieveRequestDetails)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $demands = ArchiveRequest::where('id',$id)->first();
        $details  = ArchieveRequestDetails::where('archive_request_id',$id)->get();
        


        return view('archiveRequestsDetails.archiveRequestsDetails',compact('demands','details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchieveRequestDetails $ArchieveRequestDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchieveRequestDetails $ArchieveRequestDetails)
    {
        //
    }
}
