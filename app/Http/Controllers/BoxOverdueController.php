<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;

class BoxOverdueController extends Controller
{
    public function index()
    {
        // Utilise la scope 'overdue' pour récupérer les boîtes en retard
        $overdueBoxes = Box::borrowed()->overdue()->get();

        return view('boxes.boxes_overdue', compact('overdueBoxes'));
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
