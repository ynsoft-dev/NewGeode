<?php

namespace App\Http\Controllers;

use App\Models\LoanDemand;
use App\Models\LoanDetails;
use Illuminate\Http\Request;
use App\Models\LoanRequest;
use App\Models\Post;

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
        $loans = LoanDemand::where('id', $id)->first();
        $details  = LoanDetails::where('loan_demand_id', $id)->get();
        $posts = Post::all();
        return view('loanDemands.loanDemandsDetails', compact('loans', 'details', 'posts'));
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
    public function processLoan(Request $request)
{    $loan_Id = LoanDemand::latest()->first()->id;

    // Récupérer l'ID du prêt de la session
    // $loan_Id = $request->session()->get('loan_id');
    
    // Afficher le contenu de $loanId pour le débogage
    // dd($loan_Id);

    if ($request->action == 'accept') {
        // Stocker l'ID du prêt dans une variable de session pour indiquer qu'il a été accepté
        $request->session()->put('accepted_loan', $loan_Id);
        // Rediriger l'utilisateur vers l'onglet "Loan Demand Response" (tab2)
        return redirect()->route('loanDetails.edit', ['id' => $loan_Id, 'activeTab' => 'tab2']);
    } elseif ($request->action == 'reject') {
        // Afficher un formulaire pour saisir le motif de refus dans l'onglet "Loan Demand Response" (tab2)
        return redirect()->route('loanDetails.edit', ['id' => $loan_Id, 'activeTab' => 'tab2'])->with('loan_id', $loan_Id);
    }
}
}