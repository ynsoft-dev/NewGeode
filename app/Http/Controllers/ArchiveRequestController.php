<?php

namespace App\Http\Controllers;

use App\Models\ArchiveRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Direction;

use Illuminate\Support\Facades\Auth;
use App\Models\ArchieveRequestDetails;

use Illuminate\Support\Facades\Notification;
use App\Notifications\AddRequest;

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

        $directions = Direction::all();
        $departments = Department::all();
        $demands = ArchiveRequest::all();





        return view('archiveRequests.archiveRequests', compact('directions', 'departments', 'demands'));
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


        if ($request->has('check')) {
            $validated = $request->validate([
                'direction' => 'required|max:255',
                // 'box_quantity' => 'required|numeric',
                // 'depart' => 'required',
            ], [
                'direction.required' => 'Please enter the name of the direction',
                // 'box_quantity.numeric' => 'Box quantity must be a number',
                // 'depart.required' => 'Please enter the name of the department',

            ]);

            ArchiveRequest::create([
                'name' => $request->name,
                'request_date' => $request->request_date,
                'department_id' => $request->depart,
                'direction_id' => $request->direction,
                'details_request' => $request->details_request,
            ]);


            $request_id = ArchiveRequest::latest()->first()->id;
            ArchieveRequestDetails::create([
                'archive_request_id' => $request_id,
                'name' => $request->name,
                'details_request' => $request->details_request,
                'request_date' => $request->request_date,
                // 'status' => 'Created',
                'department' => $request->depart,
                'direction' => $request->direction,

                'user' => (Auth::user()->name),
            ]);

            return redirect('/boxes');

        }


        if ($request->has('check_boxes')) {

            $lastRequest = ArchiveRequest::latest()->first();
            // $specifiedBoxQuantity = $lastRequest->box_quantity;
            $realBoxQuantity = $lastRequest->getRealBoxQuantity();
            // if ($specifiedBoxQuantity != $realBoxQuantity) {
            //     return redirect()->back()->withErrors(['box_quantity' => 'The specified box quantity does not match the real box quantity.']);
            // }
            if ($realBoxQuantity === 0) {
                return redirect()->back()->withErrors(['check_boxes' => 'Please insert at least one box.']);
            }

            return redirect('/archiveRequest')->with('Add', 'Request added successfully');
        }



        $request_id = ArchiveRequest::latest()->first()->id;
        if ($request->has('sendEmailButton')) {

            $archivistRole = Role::where('name', 'Archiviste')->first();
            if ($archivistRole) {
                $archivists = $archivistRole->users;
                foreach ($archivists as $archivist) {
                    $archivist->notify(new AddRequest($request_id));
                }
            }


            ArchiveRequest::where('id', $request_id)->update(['status' => 'Sent']);
            ArchieveRequestDetails::where('archive_request_id', $request_id)->update(['status' => 'Sent']);

            return redirect('/archiveRequest')->with('Add', 'Request sent successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ArchiveRequest $archiveRequest)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArchiveRequest $archiveRequest)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchiveRequest $demands)
    {
        $id = $request->id;

        $demands = ArchiveRequest::find($id);
        $demands->update([
            'name' => $request->name,
            'details_request' => $request->details,
            'department_id' => $request->depart,
            'direction_id' => $request->direction,
            'request_date' => $request->date,
        ]);

        if ($request->has('updateBoxButton')) {
            return redirect('/boxes');
        }

        session()->flash('edit', 'Change made successfully');
        return redirect('/archiveRequest');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $requests = ArchiveRequest::findOrFail($request->id);
        $requests->delete();
        session()->flash('delete', 'The request has been successfully deleted');
        return back();
    }

    public function getDepartments($id)
    {
        $departments = DB::table("departments")->where("directions_id", $id)->pluck("name", "id");
        return json_encode($departments);
    }
}
