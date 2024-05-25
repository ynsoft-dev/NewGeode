<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Ray;
use App\Models\Site;
use App\Models\Shelf;

class BoxLoanedController extends Controller
{
    public function index()
    {
        // Utilise la scope 'borrowed' pour récupérer les boîtes avec le statut 'Non available'
        $borrowedBoxes = Box::borrowed()->get();

        return view('boxes.boxes_loaned', compact('borrowedBoxes'));
    }
    public function returnBox(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        $box->status = 'Available';
        $box->request_number = null;
        $box->transmission_date = null;
        $box->return_date = null;
        $box->save();

        return redirect()->route('boxArchived.index')->with('edit', 'La boîte a été retournée et son statut est maintenant disponible.');
    }
}
