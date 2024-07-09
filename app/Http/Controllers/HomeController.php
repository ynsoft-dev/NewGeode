<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\Direction;
use App\Models\LoanDemand;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $acceptedDemands = ArchiveDemand::accepted()->pluck('id');

        $boxesArchivedCount = Box::whereIn('archive_demand_id', $acceptedDemands)->count();

        $demandArchiveBoxesCount = ArchiveDemand::count();
        $demandLoanBoxesCount = LoanDemand::count();
        $borrowedBoxesCount = Box::borrowed()->get()->count();
        $destroyedBoxesCount = Box::destroyed()->count();
        $overdueBorrowedBoxesCount = Box::overdue()->count();
        $siteCount = Site::count();
        $directionCount = Direction::count();
        // section user connecté
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        // Compter les demandes d'archive pour l'utilisateur connecté
        $userDemandArchiveBoxesCount = $user->archiveRequests->count();
        // Compter les demandes de prêt pour l'utilisateur connecté
        $userDemandLoanBoxesCount = $user->loanDemands->count();
        // Compter les demandes d'emprunt acceptées pour l'utilisateur connecté
        $userLoanDemandsCount = LoanDemand::where('status', 'Accepted')
            ->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->count();
        // Compter les demandes d'archive acceptées pour l'utilisateur connecté
        $userArchiveDemandsCount = ArchiveDemand::where('status', 'Accepted')
            ->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->count();
        // Récupérer les données de demande d'emprunt groupées par jour pour l'utilisateur connecté
        $userLoanDemandCountsByDay = LoanDemand::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(*) as count'))
            ->where('user_id', $user->id)
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        // Récupérer les données de demande d'archive groupées par jour pour l'utilisateur connecté
        $userArchiveDemandCountsByDay = ArchiveDemand::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(*) as count'))
            ->where('user_id', $user->id)
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        // Créer deux tableaux pour les données de date et de comptage
        $userLoanDates = $userLoanDemandCountsByDay->pluck('date')->toArray();
        $userLoanCounts = $userLoanDemandCountsByDay->pluck('count')->toArray();
        $userArchiveDates = $userArchiveDemandCountsByDay->pluck('date')->toArray();
        $userArchiveCounts = $userArchiveDemandCountsByDay->pluck('count')->toArray();
        // endSection
        // Récupérer les données de demande d'emprunt groupées par jour
        $loanDemandCountsByDay = LoanDemand::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        // Récupérer les données de demande d'archive groupées par jour
        $archiveDemandCountsByDay = ArchiveDemand::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
        // Créer deux tableaux pour les données de date et de comptage
        $loanDates = $loanDemandCountsByDay->pluck('date')->toArray();
        $loanCounts = $loanDemandCountsByDay->pluck('count')->toArray();
        // Créer deux tableaux pour les données de date et de comptage des demandes d'archive
        $archiveDates = $archiveDemandCountsByDay->pluck('date')->toArray();
        $archiveCounts = $archiveDemandCountsByDay->pluck('count')->toArray();      // dd($dates, $counts);
        return view('home', compact(
            'boxesArchivedCount',
            'userDemandArchiveBoxesCount',
            'userDemandLoanBoxesCount',
            'borrowedBoxesCount',
            'loanDates',
            'loanCounts',
            'archiveDates',
            'archiveCounts',
            'destroyedBoxesCount',
            'overdueBorrowedBoxesCount',
            'siteCount',
            'directionCount',
            'userArchiveDemandsCount',
            'userLoanDemandsCount',
            'userLoanDates',
            'userLoanCounts',
            'userArchiveDates',
            'userArchiveCounts'


        ));
    }
}
