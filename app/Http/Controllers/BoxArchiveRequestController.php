<?php

namespace App\Http\Controllers;

use App\Models\boxArchiveRequest;
use App\Models\ArchiveRequest;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Direction;
use Illuminate\Support\Facades\DB;

class BoxArchiveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions=Direction::all();
        $departments=Department::all();
        $boxes=BoxArchiveRequest::all();
        $requests=ArchiveRequest::all();
        $lastRequest = ArchiveRequest::latest()->first();
        
        
        return view('boxesArchiveRequest.boxesArchiveRequest',compact('directions','departments','boxes','requests','lastRequest'));
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
        BoxArchiveRequest::create([
            'department_id' => $request->depart,
            'content' => $request->content,
            'extreme_date'=> $request->extreme_date,
            // 'destruction_date'=> $request->destruction_date,
            'archive_request_id'=> $request->archive_requests_id,
            
            
            'direction_id' => $request->Direction,
            // 'site_id' => $request->site_id,
        ]);
        session()->flash('Add', 'Box successfully added');
        return redirect('/boxesArchiveRequest');
    }



    /**
     * Display the specified resource.
     */
    public function show(boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, boxArchiveRequest $boxArchiveRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $boxes = BoxArchiveRequest::findOrFail($request->id);
        $boxes->delete();
        session()->flash('delete', 'The box has been successfully deleted');
        return back();
    }

    public function getDepartments($id)
    {
      
    
        // Fetch rays based on the received site ID
        $departments = DB::table("departments")->where("directions_id", $id)->pluck("name", "id");
    
    
        // Return the rays as JSON
        return json_encode($departments);
    }

    public function sauvegarderDemande(Request $request)
{
    // Validation des données de la demande
    // $validatedData = $request->validate([
    //     // Définir les règles de validation ici
    // ]);

    // Vérification des conditions avant de sauvegarder la demande
    $boite = boxArchiveRequest::where('archive_request_id', $request->archive_requests_id)->first();
    return response()->json($boite);

    if ($boite && $boite->archiveRequest->name != $request->name_request && $boite->archiveRequest->request_date != $request->date_request) {
        // Supprimer les données existantes de la boite
        $boite->archiveRequest->delete();
    }

    // // Créer ou mettre à jour la demande
    // $demande = ArchiveRequest::updateOrCreate(
    //     ['id' => $request->id], // Utilisez les clés nécessaires pour identifier la demande
    //     $validatedData // Utilisez les données validées pour créer ou mettre à jour la demande
    // );

    // Autres actions à effectuer après la sauvegarde de la demande
    // Par exemple, rediriger l'utilisateur vers une autre page
}



}
