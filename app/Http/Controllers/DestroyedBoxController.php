<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use Illuminate\Support\Facades\Gate;

class DestroyedBoxController extends Controller
{
    public function index()
    {if (!Gate::allows('structureArchiviste')) {
        abort(403, 'Unauthorized action.');
    }
        $boxes = Box::onlyTrashed()->get();

        return view('boxes.boxes_deleted', compact('boxes'));
    }
}
