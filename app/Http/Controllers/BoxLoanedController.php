<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use App\Models\Shelf;
use App\Models\BoxMovement;
use Illuminate\Support\Facades\Gate;

class BoxLoanedController extends Controller
{
    public function index()
    {
        if (!Gate::allows('structureArchiviste')) {
            abort(403, 'Unauthorized action.');
        }
        // Utilise la scope 'borrowed' pour récupérer les boîtes avec le statut 'Non available'
        $borrowedBoxes = Box::borrowed()->get();

        return view('boxes.boxes_loaned', compact('borrowedBoxes'));
    }
    public function returnBox(Request $request, $id)
    {
        $request->validate([
            'real_return_date' => 'required|date',
        ]);
        $box = Box::findOrFail($id);
        // Enregistrement du mouvement de retour avec la date réelle de retour
        BoxMovement::create([
            'box_id' => $box->id,
            'request_number' => $box->request_number,
            'transmission_date' => $box->transmission_date,
            'return_date' => $box->return_date,
            'real_return_date' => $request->real_return_date,
            'status' => 'Available',
        ]);
        $box->status = 'Available';
        $box->request_number = null;
        $box->transmission_date = null;
        $box->return_date = null;
        $box->save();

        return redirect()->route('boxArchived.index')->with('edit', 'La boîte a été retournée et son statut est maintenant disponible.');
    }
}
