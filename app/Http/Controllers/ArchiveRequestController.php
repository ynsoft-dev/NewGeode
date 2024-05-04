<?php

namespace App\Http\Controllers;

use App\Models\boxArchiveRequest;
use App\Models\ArchiveRequest;
use App\Models\User;
use App\Notifications\AddRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArchiveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    
    {
        if (!Gate::allows('archiveRequest')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('archiveRequests.archiveRequests');
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
        ArchiveRequest::create([
            'name' => $request->name,
            'request_date' => $request->request_date,
            
            // 'site_id' => $request->Site,
            // 'site_id' => $request->site_id,
        ]);
        // session()->flash('Add', 'Request successfully added');


        $user= User::first();
        // $user->notify(new AddRequest($invoice));

        return redirect('/boxesArchiveRequest');


    }

    /**
     * Display the specified resource.
     */
    public function show(ArchiveRequest $archiveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArchiveRequest $archiveRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, archiveRequest $archiveRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchiveRequest $archiveRequest)
    {
        //
    }



}
