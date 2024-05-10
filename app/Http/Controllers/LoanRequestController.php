<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\Direction;
use App\Models\Department;
use App\Models\LoanDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Direction::all();
        $departments = Department::all();
        $loans = LoanRequest::all();
        return view('loanRequests.loanRequests', compact('directions', 'departments', 'loans'));
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
        $this->validate($request, [
            'Direction' => 'required',
            'depart' => 'required',
            'box_name' => 'required',
            'kind' => 'required',
            'request_date' => 'required',
            'return_date' => 'required',
            'Membership' => 'required',
        ]);
        LoanRequest::create([
            'direction_id' => $request->Direction,
            'department_id' => $request->depart,
            'box_name' => $request->box_name,
            'kind' => $request->kind,
            'request_date' => $request->request_date,
            'return_date' => $request->return_date,
            'Membership' => $request->Membership,
            'Status' => 'created',
            'Value_Status' => 1,

        ]);
        $loan_Id = LoanRequest::latest()->first()->id;
        LoanDetails::create([
            'loan_request_id' => $loan_Id,
            'direction_id' => $request->Direction,
            'department_id' => $request->depart,
            'box_name' => $request->box_name,
            'kind' => $request->kind,
            'request_date' => $request->request_date,
            'return_date' => $request->return_date,
            'Membership' => $request->Membership,
            'Status' => 'created',
            'Value_Status' => 1,
            'user' => (Auth::user()->name),
        ]);

        
        if ($request->has('sendNotificationButton')) {
            $loan_Id = LoanRequest::latest()->first()->id;
            $loans = LoanRequest::latest()->first();
            $archivistRole = Role::where('name', 'Archiviste')->first();
            if ($archivistRole) {
                $archivists = $archivistRole->users;
                foreach ($archivists as $archivist) {
                    Notification::send($archivist, new \App\Notifications\Add_loanRequest($loans));
                }
            }
            LoanRequest::where('id', $loan_Id)->update(['Status' => 'Sent']);
            LoanDetails::where('loan_request_id', $loan_Id)->update(['Status' => 'Sent']);
            return redirect('/loanRequest')->with('Add', 'Request sent successfully');
        }


        // if ($request->has('sendNotificationButton')) {

        //     $archivistRole = Role::where('name', 'Archiviste')->first();
        //     if ($archivistRole) {
        //         $archivists = $archivistRole->users;
        //         foreach ($archivists as $archivist) {
        //             $archivist->Notification::send(new \App\Notifications\Add_loanRequest($loans));

        //         }
        //     }


        //     LoanRequest::where('id', $loan_Id)->update(['status' => 'Sent']);
        //     LoanDetails::where('loan_request_id', $loan_Id)->update(['status' => 'Sent']);

        //     return redirect('/loanRequest')->with('Add', 'Request sent successfully');
        // }


        session()->flash('Add', 'Request loan successfully added');
        return redirect('/loanRequest');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanRequest $loanRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loans = LoanRequest::where('id', $id)->first();
        $directions = Direction::all();
        $departments = Department::all();
        return view('loanRequests.edit_loan', compact('directions', 'departments', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $loans = LoanRequest::findOrFail($request->loan_Id);
        $loans->update([
            'direction_id' => $request->Direction,
            'department_id' => $request->depart,
            'box_name' => $request->box_name,
            'kind' => $request->kind,
            'request_date' => $request->request_date,
            'return_date' => $request->return_date,
            'Membership' => $request->Membership,
        ]);

        session()->flash('edit', 'Request loan successfully edited');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $loans = LoanRequest::findOrFail($request->id);
        $loans->delete();
        session()->flash('delete', 'The request loan has been successfully deleted');
        return back();
    }
    public function getDepartments($id)
    {
        // Fetch rays based on the received site ID
        $departments = DB::table("departments")->where("directions_id", $id)->pluck("name", "id");
        // Return the rays as JSON
        return json_encode($departments);
    }

    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }
}