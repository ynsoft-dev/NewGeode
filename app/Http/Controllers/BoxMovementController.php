<?php

namespace App\Http\Controllers;

use App\Models\BoxMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BoxMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { if (!Gate::allows('structureArchiviste')) {
        abort(403, 'Unauthorized action.');
    }
        $movements = BoxMovement::with('box')->get();
        return view('boxes.box_movements', compact('movements'));
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
    public function show(BoxMovement $boxMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoxMovement $boxMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BoxMovement $boxMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BoxMovement $boxMovement)
    {
        //
    }
}
