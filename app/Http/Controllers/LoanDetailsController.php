<?php

namespace App\Http\Controllers;

use App\Models\LoanDetails;
use Illuminate\Http\Request;
use App\Models\LoanRequest;

class LoanDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(LoanDetails $loanDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loans = LoanRequest::where('id',$id)->first();
        $details  = LoanDetails::where('loan_request_id',$id)->get();
        return view('loanRequests.loanRequestsDetails',compact('loans','details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanDetails $loanDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanDetails $loanDetails)
    {
        //
    }
}