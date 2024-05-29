<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\LoanDemand;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $boxesArchivedCount = Box::where('status', 'archived')->count();
        $acceptedDemands = ArchiveDemand::accepted()->pluck('id');

        $boxesArchivedCount = Box::whereIn('archive_demand_id', $acceptedDemands)->count();

        $demandArchiveBoxesCount = ArchiveDemand::count();
        $demandLoanBoxesCount = LoanDemand::count();
        $borrowedBoxesCount = Box::borrowed()->get()->count();

        return view('home', compact('boxesArchivedCount', 'demandArchiveBoxesCount', 'demandLoanBoxesCount', 'borrowedBoxesCount'));    }
}
