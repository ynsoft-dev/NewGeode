<?php

namespace App\Http\Controllers;

use App\Models\LoanDemand;
use Illuminate\Http\Request;
use App\Models\Direction;
use App\Models\Department;
use App\Models\LoanAttachment;
use App\Models\LoanDetails;
use App\Models\User;
use App\Notifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Helpers\Helper;
use PgSql\Lob;
use App\Notifications\Add_loanDemandEmail;
use App\Notifications\AddLoanResponseMail;
class LoanDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Direction::all();
        $departments = Department::all();
        // $loans = LoanDemand::all();

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les demandes associées à l'utilisateur connecté
        $loans = $user->loanDemands;
        return view('loanDemands.loanDemands', compact('directions', 'departments', 'loans'));
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
    public function store(Request $request, $id)
    {
        if ($request->has('check')) {
            $this->validate($request, [
                'Direction' => 'required',
                'depart' => 'required',
                'box_name' => 'required',
                'type' => 'required',
                'request_date' => 'required',
                'return_date' => 'required',
            ]);

            $loanRequest = LoanDemand::create([
                /** Generate id */
                'borrow_id' => Helper::IDGenerator(new LoanDemand, 'borrow_id', 6, 'DP'),
                'direction_id' => $request->Direction,
                'department_id' => $request->depart,
                'box_name' => $request->box_name,
                'type' => $request->type,
                'request_date' => $request->request_date,
                'return_date' => $request->return_date,
                'Status' => 'created',
                'Value_Status' => 1,
                'user_id' => (Auth::user()->id),


            ]);

            $loan_Id = LoanDemand::latest()->first()->id;
            LoanDetails::create([
                'loan_demand_id' => $loan_Id,
                'borrow_id' => $loanRequest->borrow_id, // Utiliser le même borrow_id que celui de la demande de prêt                
                'direction_id' => $request->Direction,
                'department_id' => $request->depart,
                'box_name' => $request->box_name,
                'type' => $request->type,
                'request_date' => $request->request_date,
                'return_date' => $request->return_date,
                'Status' => 'created',
                'Value_Status' => 1,
                'user' => (Auth::user()->name),
                // 'accept_reason' => '',
                // 'rejection_reason' => '',
            ]);
        }


        if ($request->has('sendNotificationButton')) {
            $loans = LoanDemand::latest()->first();
            $loan_Id = LoanDemand::latest()->first()->id;

            $archivistRole = Role::where('name', 'Archiviste')->first();
            if ($archivistRole) {
                $archivists = $archivistRole->users;
                foreach ($archivists as $archivist) {
                    Notification::send($archivist, new \App\Notifications\Add_loanDemand($loans));
                    $archivist->notify(new Add_loanDemandEmail($loans));
                }
               
            }
            LoanDemand::where('id', $id)->update(['Status' => 'Sent']);
            LoanDetails::where('loan_demand_id', $id)->update(['Status' => 'Sent']);
            return redirect('/loanDemand')->with('Add', 'Demand sent successfully');
        }



        if ($request->has("sendResponseAEmail")) {
            $loans = LoanDemand::latest()->first();

            $userId = $request->input('user');
            $user = User::find($userId);
            // dd($userId);
            if ($user) {
                Notification::send($user, new \App\Notifications\AddLoanResponse($loans));
                $user->notify(new AddLoanResponseMail($loans));

            }

            LoanDemand::where('id', $id)->update(['Status' => 'Accepted']);
            LoanDetails::where('archive_demand_id', $id)->update(['Status' => 'Accepted']);

            // Vérifiez le type de prêt
            if ($request->loan_type == 'Copy') {
                // Redirigez vers l'onglet des pièces jointes avec un message
                return redirect()->route('loanDetails.edit', ['id' => $id, 'activeTab' => 'tab3'])->with('message', 'Demand accepted, please insert an attachment.');
            }

            // Retourner avec un message de succès si le type de prêt est "Original"
            return back()->with('Add', 'Réponse envoyée avec succès');
        }


        if ($request->has("sendResponseREmail")) {

            $loans = LoanDemand::latest()->first();

            $userId = $request->input('user');
            $user = User::find($userId);

            LoanDemand::where('id', $id)->update(['reason' => $request->reason]);

            if ($user) {
                Notification::send($user, new \App\Notifications\AddLoanResponse($loans));
                $user->notify(new AddLoanResponseMail($loans));

            }

            LoanDemand::where('id', $id)->update(['Status' => 'Refused']);
            LoanDetails::where('loan_demand_id', $id)->update(['Status' => 'Refused']);

            return back()->with('Add', 'Response sent successfully');
        }


        // if ($request->has("sendResponseREmail")) {
        //     $loans = LoanDemand::latest()->first();
        //     $userId = $request->input('user');
        //     $user = User::find($userId);

        //     LoanDemand::where('id', $loan_Id)->update(['reason' => $request->reason]);

        //     if ($user) {
        //         Notification::send($user, new \App\Notifications\AddLoanResponse($loans));
        //     }

        //     LoanDemand::where('id', $loan_Id)->update(['Status' => 'Refused']);
        //     LoanDetails::where('loan_demand_id', $loan_Id)->update(['Status' => 'Refused']);

        //     return back()->with('Add', 'Response sent successfully');
        // }

        session()->flash('Add', 'Demand loan successfully added');
        return redirect('/loanDemand');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanDemand $loanDemand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loans = LoanDemand::where('id', $id)->first();
        $directions = Direction::all();
        $departments = Department::where('directions_id', $loans->direction_id)->get();
        return view('loanDemands.edit_loan', compact('directions', 'departments', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanDemand $loans)
    {
        $loans = LoanDemand::findOrFail($request->loan_Id);
        $loans->update([
            'direction_id' => $request->Direction,
            'department_id' => $request->depart,
            'box_name' => $request->box_name,
            'type' => $request->type,
            'request_date' => $request->request_date,
            'return_date' => $request->return_date,
        ]);

        session()->flash('edit', 'Demand loan successfully edited');
        return redirect('/loanDemand');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $requests = LoanDemand::findOrFail($request->id);
        $requests->delete();
        session()->flash('delete', 'The request has been successfully deleted');
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
    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification) {

            return $notification->data['borrow'];
        }
    }
}