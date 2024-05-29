<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;

class DestroyedBoxController extends Controller
{
    public function index()
    {
        $boxes = Box::onlyTrashed()->get();

        return view('boxes.boxes_deleted', compact('boxes'));
    }
}
