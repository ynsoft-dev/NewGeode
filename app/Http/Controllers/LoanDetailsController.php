<?php

namespace App\Http\Controllers;

use App\Models\LoanDemand;
use App\Models\LoanDetails;
use Illuminate\Http\Request;
use App\Models\LoanRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use PgSql\Lob;

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
        $loans = LoanDemand::where('id', $id)->first();
        $details  = LoanDetails::where('loan_demand_id', $id)->get();

        // $lastLoans = LoanDetails::latest()->first();

        // $lastLoan = LoanDetails::latest()->first()->id;
        // $posts = Post::where('loan_detail_id', $lastLoan)->get();

        // Récupérer les IDs des LoanDetails associées
        $loanDetailIds = $details->pluck('id');
        // Récupérer les posts associés aux LoanDetails
        $posts = Post::whereIn('loan_detail_id', $loanDetailIds)->get();
        return view('loanDemands.loanDemandsDetails', compact('loans', 'details', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanDetails $loanDetails)
    {
        //
    }
}