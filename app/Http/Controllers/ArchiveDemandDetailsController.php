<?php

namespace App\Http\Controllers;

use App\Models\ArchiveDemandDetails;
use App\Models\ArchiveDemand;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddDemand;
use Spatie\Permission\Models\Role;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Illuminate\Http\Request;

class ArchiveDemandDetailsController extends Controller
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
    }

    /**
     * Display the specified resource.
     */
    public function show(ArchiveDemandDetails $ArchiveDemandDetails)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $demands = ArchiveDemand::where('id', $id)->first();
        $details  = ArchiveDemandDetails::where('archive_demand_id', $id)->get();
        $mediaItems = Media::all(); 

        return view('archiveDemandsDetails.archiveDemandsDetails', compact('demands', 'details','mediaItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchiveDemandDetails $ArchiveDemandDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchiveDemandDetails $ArchiveDemandDetails)
    {
        //
    }
}
