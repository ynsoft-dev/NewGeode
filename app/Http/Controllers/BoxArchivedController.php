<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use App\Models\Shelf;
use App\Models\BoxMovement;
use App\Models\LoanDemand;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
class BoxArchivedController extends Controller
{
    public function index()
    {
        $acceptedDemands = ArchiveDemand::accepted()->pluck('id');

        $boxes = Box::whereIn('archive_demand_id', $acceptedDemands)->get();

        $sites = Site::all();
        $columns = Column::all();
        $rays = Ray::all();
        $shelves = Shelf::all();


   
        // Instanciez LoanDemandController et récupérez les données
        $loanDemandController = new LoanDemandController();
        $loanDemandData = $loanDemandController->index();

        // Accédez aux données de demande de prêt
        $loanDemandNumbers = $loanDemandData['loanDemandNumbers'] ?? [];
        $returnDates = $loanDemandData['returnDates'] ?? [];
        $requestDates = $loanDemandData['requestDates'] ?? [];

        return view('boxes.boxes_archived', compact('boxes', 'sites', 'columns', 'rays', 'shelves', 'loanDemandNumbers', 'returnDates','requestDates'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $boxes = Box::where('id', $id)->first();
        $sites = Site::all();
        $columns = Column::all();
        $rays = Ray::all();
        $shelves = Shelf::all();
        return view('boxes.boxes_archived_edit', compact('boxes', 'sites', 'columns', 'rays', 'shelves'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $shelfId = $request->input('shelf_id');
        $shelf = Shelf::find($shelfId);
        $capacity = $shelf->capacity;
        $numberOfBoxes = Box::where('shelf_id', $shelfId)->count();
        // dd($shelfId, $capacity,$numberOfBoxes);

        $Id = $request->id;
        // $Id = Box::where('shelf_id', $shelfId)->pluck('id');
        $boxes = Box::find($Id);
        if ($numberOfBoxes < $capacity) {
            $boxes->update([
                'shelf_id' => $request->input('shelf_id'),
                'location' => $request->input('location'),
            ]);
            if ($request->has('editLocation')) {
                session()->flash('edit', 'Location updated successfully');
                // return back();
            } else {
                session()->flash('edit', 'Location added successfully');
            }
            return redirect('/boxArchived');
        } else {
            // dd('not');
            session()->flash('delete', 'The shelf is full. Please change the location');
            // return back();
            return redirect('/boxArchived');
        }
    }


    public function getRays($id)
    {
        // Fetch rays based on the received site ID
        $rays = DB::table("rays")->where("site_id", $id)->pluck("name", "id");

        // Return the rays as JSON
        return json_encode($rays);
    }

    public function getColumns($id)
    {
        // Fetch columns based on the received ray ID
        $columns = DB::table("columns")->where("ray_id", $id)->pluck("name", "id");

        // Return the columns as JSON
        return json_encode($columns);
    }

    public function getShelves($id)
    {

        $shelves = DB::table("shelves")->where("column_id", $id)->pluck("name", "id");


        return json_encode($shelves);
    }
    public function borrow(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        // dd($box);
        // Enregistrement du mouvement de prêt
        BoxMovement::create([
            'box_id' => $box->id,
            'request_number' => $request->request_number,
            'transmission_date' => $request->transmission_date,
            'return_date' => $request->return_date,
            'status' => 'Not available',
        ]);

        $box->status = 'Not available';
        $box->request_number = $request->request_number;
        $box->transmission_date = $request->transmission_date;
        $box->return_date = $request->return_date;
        $box->save();


        return redirect()->back()->with('edit', 'Box status changed to Not available successfully');
    }
    public function destroy(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        $destruction_option = $request->input('destruction_option');

        if ($destruction_option === 'planned_in') {
            $box->destruction_date = $request->input('destruction_date');
        } else {
            $box->destruction_date = 'unlimited';
        }

        $box->save();

        return redirect()->back()->with('edit', 'Box marked for destruction successfully');

    }

    public function pendingDestruction()
    {
        $boxes = Box::where('destruction_date', '!=', 'not defined')->get();

        return view('boxes.pending_destruction', compact('boxes'));
    }

    
}
