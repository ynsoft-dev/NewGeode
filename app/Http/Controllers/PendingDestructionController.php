<?php

namespace App\Http\Controllers;

use App\Models\Box;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PendingDestructionController extends Controller
{
    public function index()
    {
        if (!Gate::allows('structureArchiviste')) {
            abort(403, 'Unauthorized action.');
        }
        // Sélectionner toutes les boîtes dont la date de destruction n'est ni "not defined" ni "unlimited"
        $boxes = Box::where('destruction_date', '!=', 'not defined')
            ->where('destruction_date', '!=', 'UNLIMITED')
            ->get();

        return view('boxes.pending_destruction', compact('boxes'));
    }
    public function destroy(Request $request, $id)
    {
        $box = Box::findOrFail($id);
        $box->delete();  // Use soft delete

        return redirect()->back()->with('edit', 'Box deleted successfully');
    }

    public function showDeleted()
    {
        $boxes = Box::onlyTrashed()->get();

        return view('boxes.boxes_deleted', compact('boxes'));
    }
}
