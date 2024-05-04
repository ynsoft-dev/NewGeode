<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\Direction;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions=Direction::all();
        $departments=Department::all();
        $loans=LoanRequest::all();
        return view('loanRequests.loanRequests',compact('directions','departments','loans'));

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
            'post_number' => 'required',
            'box_name' => 'required',
            'request_date' => 'required',
            'return_date' => 'required',
            'Membership' => 'required',
        ]);
        LoanRequest::create([
            'direction_id' => $request->Direction,
            'department_id' => $request->depart,
            'post_number' => $request->post_number,
            'box_name'=> $request->box_name,
            'request_date'=> $request->request_date,
            'return_date'=> $request->return_date,
            'Membership' => $request->Membership,
        ]);
        $loan_id = LoanRequest::latest()->first()->id;

        $user = User::get();
        $loans = LoanRequest::latest()->first();
        Notification::send($user, new \App\Notifications\Add_loanRequest($loans));

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
    public function edit(LoanRequest $loanRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanRequest $loanRequest)
    {
        //
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
}
