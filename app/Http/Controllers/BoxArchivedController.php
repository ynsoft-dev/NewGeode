<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\ArchiveDemand;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use App\Models\Shelf;
use Illuminate\Support\Facades\DB;
use App\Models\BoxMovement;
use Carbon\Carbon;
use App\Models\User;

class BoxArchivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acceptedDemands = ArchiveDemand::accepted()->pluck('id');

        $boxes = Box::whereIn('archive_demand_id', $acceptedDemands)->get();

        $sites = Site::all();
        // $columns = Column::where('site_id', request->idSite)->get();

        $columns = Column::all();
        $rays = Ray::all();
        $rays = Ray::all();
        $shelves = Shelf::all();
        // $shelves = Shelf::where('id', $boxes->shelf_id)->get();

        // Instanciez LoanDemandController et récupérez les données
        $loanDemandController = new LoanDemandController();
        $loanDemandData = $loanDemandController->index();
        // dd($loanDemandData);

        // Accédez aux données de demande de prêt
        $loanDemandNumbers = $loanDemandData['loanDemandNumbers'] ?? [];
        $returnDates = $loanDemandData['returnDates'] ?? [];
        $requestDates = $loanDemandData['requestDates'] ?? [];
      



        return view('boxes.boxes_archived', compact('boxes', 'sites', 'columns', 'rays', 'shelves', 'loanDemandNumbers', 'returnDates', 'requestDates'));
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
    public function edit($id)
    {
        $boxes = Box::where('id', $id)->first();
        // dd($boxes->shelf_id);
        $sites = Site::all();


        // $rays = Ray::all();

        $rays = Ray::where('site_id', $boxes->site_id)->get();
        // dd($boxes->site_id);

        $columns = Column::where('ray_id', $boxes->ray_id)->get();
        // $columns = Column::all();

        // dd($boxes->ray_id);

        $shelves = Shelf::where('column_id', $boxes->column_id)->get();
        // $shelves = Shelf::all();

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

        // $siteId = $request->input('siteId');
        // dd($siteId);


        $Id = $request->id;
        // $Id = Box::where('shelf_id', $shelfId)->pluck('id');
        $boxes = Box::find($Id);



        if ($numberOfBoxes < $capacity) {
            $boxes->update([
                'shelf_id' => $request->input('shelf_id'),
                'location' => $request->input('location'),

                'site_id' => $request->input('siteId'),
                'ray_id' => $request->input('ray_id'),
                'column_id' => $request->input('column_id'),

            ]);
            if ($request->has('editLocation')) {

                session()->put('edit', 'Location updated successfully');
                // return back();
            } else {
                session()->put('edit', 'Location added successfully');
            }
            return redirect('/boxArchived');
        } else {
            // dd('not');
            session()->put('delete', 'The shelf is full. Please change the location');
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
