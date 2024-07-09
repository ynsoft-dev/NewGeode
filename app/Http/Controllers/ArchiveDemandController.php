<?php

namespace App\Http\Controllers;

use App\Models\ArchiveDemand;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Direction;

use Illuminate\Support\Facades\Auth;
use App\Models\ArchiveDemandDetails;

use Illuminate\Support\Facades\Notification;
use App\Notifications\AddDemand;
use App\Notifications\AddResponse;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;



class ArchiveDemandController extends Controller
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
        // $demands = ArchiveRequest::all();


        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les demandes associées à l'utilisateur connecté
        $demands = $user->archiveRequests;
        // $demands = $user->archiveRequests()->orderBy('request_date', 'desc')->get();





        return view('archiveDemands.archiveDemands', compact('directions', 'departments', 'demands'));
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
            $validated = $request->validate([
                'direction' => 'required|max:255',
                // 'box_quantity' => 'required|numeric',
                'depart' => 'required',
            ], [
                'direction.required' => 'Please enter the name of the direction',
                // 'box_quantity.numeric' => 'Box quantity must be a number',
                'depart.required' => 'Please enter the name of the department',

            ]);

            // $demand_archive_id = Helper::IDGenerator(new ArchiveDemand(), 'demand_archive_id', 6, 'DA');

            // $dmd = new ArchiveDemand();
            // $dmd->demand_archive_id = $demand_archive_id;
            // $dmd->name = $request->name;
            // $dmd->request_date = $request->request_date;
            // // $dmd->request_date = Carbon::createFromFormat('m/d/Y', $request->request_date)->format('d/m/Y');
            // $dmd->department_id = $request->depart;
            // $dmd->direction_id = $request->direction;
            // $dmd->details_request = $request->details_request;
            // $dmd->user_id = Auth::user()->id;

            // $dmd->save();

            // $demand_archive_id = Helper::IDGenerator(new ArchiveDemand(), 'demand_archive_id', 6, 'DA');

            ArchiveDemand::create([
                'demand_archive_id' => Helper::IDGenerator(new ArchiveDemand(), 'demand_archive_id', 6, 'DA'),
                'name' => $request->name,
                'request_date' => $request->request_date,
                // 'request_date' => Carbon::createFromFormat('m/d/Y', $request->request_date)->format('d/m/Y'),
                'department_id' => $request->depart,
                'direction_id' => $request->direction,
                'details_request' => $request->details_request,
                'user_id' => Auth::user()->id,
            ]);



            $request_id = ArchiveDemand::latest()->first()->id;
            ArchiveDemandDetails::create([
                'archive_demand_id' => $request_id,
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

            $lastRequest = ArchiveDemand::latest()->first();
            // $specifiedBoxQuantity = $lastRequest->box_quantity;
            $realBoxQuantity = $lastRequest->getRealBoxQuantity();
            // if ($specifiedBoxQuantity != $realBoxQuantity) {
            //     return redirect()->back()->withErrors(['box_quantity' => 'The specified box quantity does not match the real box quantity.']);
            // }
            if ($realBoxQuantity === 0) {
                return redirect()->back()->withErrors(['check_boxes' => 'Please insert at least one box.']);
            }
            


            return redirect('/archiveDemand')->with('Add', 'Demand added successfully');

        }

        if ($request->has('check_boxes_edit')) {

            $demand = ArchiveDemand::where('id', $id)->first();
            // $specifiedBoxQuantity = $lastRequest->box_quantity;
            $realBoxQuantity = $demand->getRealBoxQuantity();
            // if ($specifiedBoxQuantity != $realBoxQuantity) {
            //     return redirect()->back()->withErrors(['box_quantity' => 'The specified box quantity does not match the real box quantity.']);
            // }
            if ($realBoxQuantity === 0) {
                return redirect()->back()->withErrors(['check_boxes_edit' => 'Please insert at least one box.']);
            }

            return redirect('/archiveDemand');
        }





        if ($request->has('sendEmailButton')) {

            // $request_id = ArchiveDemand::latest()->first()->id;
            $request_id = ArchiveDemand::where('id', $id)->first();


            $archivistRole = Role::where('name', 'Archiviste')->first();
            if ($archivistRole) {
                $archivists = $archivistRole->users;
                foreach ($archivists as $archivist) {
                    Notification::send($archivist, new \App\Notifications\AddArchiveResponse($request_id, 'archive'));
                    $archivist->notify(new AddDemand($id));
                }
            }
            ArchiveDemand::where('id', $id)->update(['status' => 'Sent']);
            ArchiveDemandDetails::where('archive_demand_id', $id)->update(['status' => 'Sent']);

            return redirect('/archiveDemand')->with('Add', 'Demand sent successfully');
        }

        if ($request->has("sendResponseAEmail")) {
            $request_id = ArchiveDemand::where('id', $id)->first();

            $userId = $request->input('user');
            $user = User::find($userId);
            // dd($userId);
            if ($user) {
                Notification::send($user, new \App\Notifications\AddArchiveResponse($request_id, 'archive'));
                $user->notify(new AddResponse($id)); 
            }

            ArchiveDemand::where('id', $id)->update(['status' => 'Accepted']);
            ArchiveDemandDetails::where('archive_demand_id', $id)->update(['status' => 'Accepted']);

            return back()->with('Add', 'Response sent successfully');
        }

        if ($request->has("sendResponseREmail")) {
            $request_id = ArchiveDemand::where('id', $id)->first();

            $userId = $request->input('user');
            $user = User::find($userId);

            ArchiveDemand::where('id', $id)->update(['reason' => $request->reason]);

            if ($user) {
                Notification::send($user, new \App\Notifications\AddArchiveResponse($request_id, 'archive'));
                $user->notify(new AddResponse($id)); // 
            }

            ArchiveDemand::where('id', $id)->update(['status' => 'Refused']);
            ArchiveDemandDetails::where('archive_demand_id', $id)->update(['status' => 'Refused']);

            return back()->with('Add', 'Response sent successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ArchiveDemand $archiveDemand)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $demands = ArchiveDemand::where('id', $id)->first();
        $directions = Direction::all();
        // $departments = Department::all();
        $departments = Department::where('directions_id', $demands->direction_id)->get();
        return view('archiveDemands.edit_archive', compact('directions', 'departments', 'demands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $demands = ArchiveDemand::find($id);
        $demands->update([
            'name' => $request->name,
            'details_request' => $request->details,
            'department_id' => $request->depart,
            'direction_id' => $request->direction,
            'request_date' => $request->date,
            'user_id' => (Auth::user()->id),

        ]);


        if ($request->has('updateBoxButton')) {
            return redirect('/edit_box/' . $id);
        }

        session()->flash('edit', 'Demand successfully updated');
        return redirect('/archiveDemand');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $demands = ArchiveDemand::findOrFail($request->id);
        $demands->delete();

        session()->flash('delete', 'The demand has been successfully deleted');
        $value = session()->get('delete');
        // dd(session()->all());
        // dd($value);
        return back();
        // return redirect('/archiveDemand')->with('delete', 'The demand has been successfully deleted');


    }

    public function getDepartments($id)
    {
        $departments = DB::table("departments")->where("directions_id", $id)->pluck("name", "id");
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
