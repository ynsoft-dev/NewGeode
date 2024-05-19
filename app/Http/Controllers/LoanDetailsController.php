<?php

namespace App\Http\Controllers;

use App\Models\LoanDemand;
use App\Models\LoanDetails;
use Illuminate\Http\Request;
use App\Models\LoanRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;


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
        $posts = Post::all();
        $loanDetails = $details->first();
        // dd($loans, $details, $posts);
        return view('loanDemands.loanDemandsDetails', compact('loans', 'details', 'posts', 'loanDetails'));
    }

    /**
     * Update the specified resource in storage.
     */
     
    
    public function update(Request $request, $id)
    {if (!Gate::allows('process_loan')) {
        abort(403, 'Unauthorized action.');}
        $loanDetails = LoanDetails::findOrFail($id);

        if ($request->has('acceptButton')) {
            if ($loanDetails->type === 'Copy') {
                // Mettre à jour le statut directement
                $loanDetails->Status = 'Accepted';
                $loanDetails->Value_Status = 3;
                $loanDetails->save();

                // Redirection vers l'onglet "Loan Attachment" (tab3)
                return redirect()->route('loanDetails.edit', ['id' => $loanDetails->loan_demand_id, 'activeTab' => 'tab3'])
                    ->with('edit', 'Statut mis à jour avec succès');
            } elseif ($request->filled('accept_reason')) {
                // Mettre à jour le statut avec le motif d'acceptation
                $loanDetails->accept_reason = $request->input('accept_reason');
                $loanDetails->Status = 'Accepted';
                $loanDetails->Value_Status = 3;
                $loanDetails->save();

                // Redirection vers l'onglet "Loan Demand Response" (tab2)
                return redirect()->route('loanDetails.edit', ['id' => $loanDetails->loan_demand_id, 'activeTab' => 'tab2'])
                    ->with('edit', 'Statut mis à jour avec succès');
            } else {
                return back()->withErrors(['accept_reason' => 'Le motif d\'acceptation est requis.']);
            }
        } elseif ($request->has('rejectButton')) {
            if ($request->filled('rejection_reason')) {
                $loanDetails->rejection_reason = $request->input('rejection_reason');
                $loanDetails->Status = 'Rejected';
                $loanDetails->Value_Status = 4;
                $loanDetails->save();

                // Redirection vers l'onglet "Loan Demand Response" (tab2) après le rejet
                return redirect()->route('loanDetails.edit', ['id' => $loanDetails->loan_demand_id, 'activeTab' => 'tab2'])
                    ->with('edit', 'Statut mis à jour avec succès');
            } else {
                return back()->withErrors(['rejection_reason' => 'Le motif de refus est requis.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanDetails $loanDetails)
    {
        //
    }
}
